<?php

namespace App\Http\Livewire;

use App\Mail\NewOrderNotification;
use Livewire\Component;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\CartGroup;
use App\Models\OrderDetail;
use Livewire\WithFileUploads;
use App\Models\PaymentMethod;
use App\Models\DeliveryDetails;
use App\Models\OrderExtraDetails;
use App\Models\ReceipentsDetails;
use App\Settings\SettingSingleton;
use App\Traits\FileHandler;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutForm extends Component
{
    use WithFileUploads, FileHandler;

    public $sender_email;
    public $sender_name;
    public $sender_mobile;
    public $recipient_first_name;
    public $recipient_last_name;
    public $recipient_mobile;
    public $st_name;
    public $apartment;
    public $floor;
    public $area;
    public $payment_method;
    public $delivery_option;
    public $delivery_date;
    public $delivery_time;
    public $extra_instructions;
    public $greeting_card;
    public $governorate;
    public $receipt_image;

    public $carts;
    public $subtotal;
    public $shippingCost;
    public $taxRate;
    public $taxAmount;
    public $finalTotal;
    public $paymentMethods;

    public $orderTotal;

    protected $rules = [
        'sender_email' => 'nullable|email',
        'sender_name' => 'nullable|string|max:255|min:3',
        'sender_mobile' => 'required|digits_between:10,15',
        'recipient_first_name' => 'nullable|string|max:255',
        'recipient_last_name' => 'nullable|string|max:255',
        'recipient_mobile' => 'nullable|digits_between:10,15',
        'st_name' => 'required|string|max:255',
        'apartment' => 'required|string|max:255',
        'floor' => 'required|string|max:255',
        'area' => 'nullable|string|max:255',
        'payment_method' => 'required|exists:payment_methods,unique_name',
        'delivery_option' => 'nullable|in:same_day,schedule',

        'extra_instructions' => 'nullable|string',
        'greeting_card' => 'nullable|string',
        // 'governorate' => 'required',
        'receipt_image' => 'nullable|image|max:2048',
    ];

    public function mount($deliveryOption, $deliveryDate, $deliveryTime)
    {
        $this->delivery_option = $deliveryOption;
        $this->delivery_date = $deliveryDate;
        $this->delivery_time = $deliveryTime;

        $cookeries = Cookie::get('cart_cookie');
        $cartGroup = CartGroup::where('cookeries', $cookeries)->first();
        $this->carts = $cartGroup
            ? Cart::with('product')->where('cart_group_id', $cartGroup->id)->get()
            : collect();

        $this->subtotal = $this->carts->sum('total_price');
        $this->governorate = session('governorate', 'Downtown');

        $shippingRates = [
            'Downtown' => SettingSingleton::getInstance()->getItem('Downtown') ?? 0.0,
            'Zamalek' => SettingSingleton::getInstance()->getItem('Zamalek') ?? 0.0,
            'Garden_City' => SettingSingleton::getInstance()->getItem('Garden_City') ?? 0.0,
            'ElManial' => SettingSingleton::getInstance()->getItem('ElManial') ?? 0.0,
            'Nasr_City' => SettingSingleton::getInstance()->getItem('Nasr_City') ?? 0.0,
            'Heliopolis' => SettingSingleton::getInstance()->getItem('Heliopolis') ?? 0.0,
            'Abbassia' => SettingSingleton::getInstance()->getItem('Abbassia') ?? 0.0,
            'Roxy' => SettingSingleton::getInstance()->getItem('Roxy') ?? 0.0,
            'ElNozha' => SettingSingleton::getInstance()->getItem('ElNozha') ?? 0.0,
            'Sheraton' => SettingSingleton::getInstance()->getItem('Sheraton') ?? 0.0,
            'Shubra' => SettingSingleton::getInstance()->getItem('Shubra') ?? 0.0,
            'Maadi' => SettingSingleton::getInstance()->getItem('Maadi') ?? 0.0,
            'Helwan' => SettingSingleton::getInstance()->getItem('Helwan') ?? 0.0,
            'ElRehab' => SettingSingleton::getInstance()->getItem('ElRehab') ?? 0.0,
            'Madinaty' => SettingSingleton::getInstance()->getItem('Madinaty') ?? 0.0,
            'The_fifth_settlement' => SettingSingleton::getInstance()->getItem('The_fifth_settlement') ?? 0.0,
            'Giza' => SettingSingleton::getInstance()->getItem('Giza') ?? 0.0,
            'Dokki' => SettingSingleton::getInstance()->getItem('Dokki') ?? 0.0,
            'Mohandessin' => SettingSingleton::getInstance()->getItem('Mohandessin') ?? 0.0,
            'Agouza' => SettingSingleton::getInstance()->getItem('Agouza') ?? 0.0,
            'Imbaba' => SettingSingleton::getInstance()->getItem('Imbaba') ?? 0.0,
            'Faisal' => SettingSingleton::getInstance()->getItem('Faisal') ?? 0.0,
            '6th_of_October_City' => SettingSingleton::getInstance()->getItem('6th_of_October_City') ?? 0.0,
            'Sheikh_Zayed' => SettingSingleton::getInstance()->getItem('Sheikh_Zayed') ?? 0.0,
            'Haram' => SettingSingleton::getInstance()->getItem('Haram') ?? 0.0,
        ];
        $this->shippingCost = $shippingRates[$this->governorate] ?? 0;

        $this->taxRate = SettingSingleton::getInstance()->getItem('tax') ?? 0;

        $this->calculateTotals();

        $this->paymentMethods = PaymentMethod::where('status', 'active')->get();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function calculateTotals()
    {
        $coupon   = session('coupon', null);
        $discount = $coupon['amount'] ?? 0;

        $threshold = SettingSingleton::getInstance()->getUpperNotify('upper_price') ?? 0;

        $originalShipping = SettingSingleton::getInstance()->getItem($this->governorate) ?? 0;

        if ($discount == 0 && $this->subtotal > $threshold) {
            $shipping = 0;
        } else {
            $shipping = $originalShipping;
        }

        $this->shippingCost = $shipping;

        $taxableBase = max(0, $this->subtotal - $discount) + $this->shippingCost;
        $this->taxAmount = $taxableBase * $this->taxRate;

        $this->finalTotal = $taxableBase + $this->taxAmount;

        $this->orderTotal = $taxableBase;
    }

    public function selectPaymentMethod($val)
    {
        $this->payment_method = $val;
    }

    public function submit()
    {

        $pdata =$this->validate();


        $subTotal = $this->carts->sum('total_price');

        if ($this->carts->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }
        $user = User::firstOrCreate(
            ['email' => $this->sender_email],
            [
                'name' => $this->sender_name,
                'mobile' => $this->sender_mobile,
                'password' => bcrypt('temp_password'),
            ]
        );

        $receiptImagePath = null;
        if ($this->receipt_image) {
            $receiptImagePath= $this->upload_file($this->receipt_image, ('orders'));
        }

        $address = implode(', ', [
            $this->st_name,
            $this->apartment,
            $this->floor,
            $this->area,
        ]);
        $identifier = time() . rand(1000, 9999);
        $discount = session('coupon')['amount'] ?? 0;

        $shippingCost = $this->shippingCost;

        $subtotal = $this->subtotal;

        $orderTotal = $subtotal + $shippingCost - $discount;

        $orderTotal = max(0, $orderTotal);
        $order = Order::create([
            'identifier' => $identifier,
            'customer_name' => $this->sender_name,
            'customer_mobile' => $this->sender_mobile,
            'customer_email' => $this->sender_email,
            'total_quantity' => $this->carts->sum('quantity'),
            'payment_method_id' => PaymentMethod::where('unique_name', $this->payment_method)->first()?->id,
            'status' => 'pending',
            'shipped_price' => $shippingCost,
            'total'             => $orderTotal,
            'promo_code_id' => session('coupon')['id'] ?? null,
            'discount' => session('coupon')['amount'] ?? 0,
            'address' => $address,
            'created_by' => $user->id,
            'image' => $receiptImagePath,
        ]);

        DeliveryDetails::create([
            'st_name' => $this->st_name,
            'apartment' => $this->apartment,
            'floor' => $this->floor,
            'area' => $this->area,
            'order_id' => $order->id,
            'shipping_cost' => $this->shippingCost,
            'total' => $this->finalTotal,
            'payment_method_id' => $order->payment_method_id,
            'status' => 1,
        ]);

        foreach ($this->carts as $cart) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'product_name' => $cart->product_name ?? $cart->product->name,
                'price' => $cart->price,
                'price_after_sale' => $cart->price_after_sale ?? $cart->price,
                'quantity' => $cart->quantity,
                'total' => $cart->total_price,
                'user_input' => $cart->user_input,
                'created_by' => $user->id,
            ]);
        }

        ReceipentsDetails::create([
            'order_id' => $order->id,
            'name' => $this->recipient_first_name . ' ' . $this->recipient_last_name,
            'mobile' => $this->recipient_mobile,
            'address' => $address,
        ]);

        OrderExtraDetails::create([
            'order_id' => $order->id,
            'extra_instructions' => $this->extra_instructions,
            'greeting_card' => $this->greeting_card,
            'same_day' => $this->delivery_option === 'same_day',
            'delivery_date' => $this->delivery_option === 'same_day'
                ? now()->toDateString()
                : $this->delivery_date,
            'specific_time_slot_status' => $this->delivery_option === 'schedule',
            'specific_time' => $this->delivery_option === 'schedule'
                ? $this->delivery_time
                : null,
        ]);

        $cartGroup = CartGroup::where('cookeries', Cookie::get('cart_cookie'))->first();
        Cart::where('cart_group_id', $cartGroup->id)->delete();
        session()->forget('coupon');
        Cookie::queue(Cookie::forget('cart_cookie'));

        $order_email_1 = SettingSingleton::getInstance()->getItem('order_email_1');
        $order_email_2 = SettingSingleton::getInstance()->getItem('order_email_2');

        try {
            $email = Mail::to([$order_email_1, $order_email_2])
                ->send(new NewOrderNotification($order));
        } catch (\Exception $e) {
        }

        // event(new \App\Events\OrderCreated($order));
        // dd($order);
        return redirect()->route('site.orders.show', ['order' => $order->id])
            //  return redirect()->route('site.cart')

            ->with('success', 'Order has been placed successfully.');
    }

    public function render()
    {
        return view('livewire.checkout-form', [
            'carts' => $this->carts,
            'subtotal' => $this->subtotal,
            'shippingCost' => $this->shippingCost,
            'taxRate' => $this->taxRate,
            'taxAmount' => $this->taxAmount,
            'finalTotal' => $this->finalTotal,
            'paymentMethods' => $this->paymentMethods,
        ]);
    }
}

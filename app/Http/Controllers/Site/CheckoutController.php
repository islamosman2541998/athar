<?php

namespace App\Http\Controllers\Site;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\CartGroup;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\DeliveryDetails;
use App\Models\OrderExtraDetails;
use App\Models\ReceipentsDetails;
use App\Settings\SettingSingleton;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
{
   public function index(Request $request)
    {
        $cookeries = Cookie::get('cart_cookie');
        $cartGroup = CartGroup::where('cookeries', $cookeries)->first();
        $carts     = $cartGroup
            ? Cart::with('product')->where('cart_group_id', $cartGroup->id)->get()
            : collect();

            if($carts->isEmpty()) {
                return redirect()->route('site.cart')->with('error', 'Your cart is empty.');
            }
        $subtotal = $carts->sum('total_price');

        $governorate = session('governorate', 'Downtown');
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
        $shippingCost = $shippingRates[$governorate] ?? 0;

        $taxRate = SettingSingleton::getInstance()->getItem('tax') ?? 0;

        $coupon = session('coupon', null);
        $discount = $coupon['amount'] ?? 0;

        $threshold = SettingSingleton::getInstance()->getUpperNotify('upper_price') ?? 0;

        if ($discount == 0 && $subtotal > $threshold) {
            $shippingCost = 0;
        }

        $taxableBase = max(0, $subtotal - $discount) + $shippingCost;
        $taxAmount = $taxableBase * $taxRate;
        $finalTotal = $taxableBase + $taxAmount;

        $paymentMethods = PaymentMethod::where('status', 'active')->get();

        $deliveryOption = $request->input('delivery_option', 'same_day');
        $deliveryDate = $request->input('delivery_date');
        $deliveryTime = $request->input('delivery_time');

        return view('site.pages.checkout', [
            'deliveryOption' => $deliveryOption,
            'deliveryDate' => $deliveryDate,
            'deliveryTime' => $deliveryTime,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender_email'         => 'nullable|email',
            'sender_name'          => 'nullable|string|max:255',
            'sender_mobile'        => 'required|digits_between:10,15',
            'recipient_first_name' => 'required|string|max:255',
            'recipient_last_name'  => 'required|string|max:255',
            'recipient_mobile'     => 'required|digits_between:10,15',
            'st_name'              => 'required|string|max:255',
            'apartment'            => 'required|string|max:255',
            'floor'                => 'required|string|max:255',
            'area'                 => 'required|string|max:255',
            'payment_method'       => 'required|exists:payment_methods,unique_name',
            'delivery_option'      => 'required|in:same_day,schedule',
            'delivery_date'        => 'required_if:delivery_option,schedule|date',
            'delivery_time'        => 'required_if:delivery_option,schedule|date_format:H:i',
            'extra_instructions'   => 'nullable|string',
            'greeting_card'        => 'nullable|string',
            'governorate'          => 'required|in:cairo,giza',
        ]);

        $cookeries = Cookie::get('cart_cookie');
        $cartGroup = CartGroup::where('cookeries', $cookeries)->first();
        $carts     = $cartGroup
            ? Cart::where('cart_group_id', $cartGroup->id)->with('product')->get()
            : collect();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subTotal = $carts->sum('total_price');
        $governorate = session('governorate', $validated['governorate'] ?? 'Downtown');

        // $shippingCairo = SettingSingleton::getInstance()->getItem('shipping_cairo') ?? 0;
        // $shippingGiza  = SettingSingleton::getInstance()->getItem('shipping_giza') ?? 0;
        
         $shippingDowntown  = SettingSingleton::getInstance()->getItem('Downtown') ?? 0.0;
        $shippingZamalek  = SettingSingleton::getInstance()->getItem('Zamalek') ?? 0.0;
        $shippingGardenCity  = SettingSingleton::getInstance()->getItem('Garden_City') ?? 0.0;
        $shippingElManial  = SettingSingleton::getInstance()->getItem('ElManial') ?? 0.0;
        $shippingNasrCity  = SettingSingleton::getInstance()->getItem('Nasr_City') ?? 0.0;
        $shippingHeliopolis  = SettingSingleton::getInstance()->getItem('Heliopolis') ?? 0.0;
        $shippingAbbassia  = SettingSingleton::getInstance()->getItem('Abbassia') ?? 0.0;
        $shippingRoxy  = SettingSingleton::getInstance()->getItem('Roxy') ?? 0.0;
        $shippingElNozha  = SettingSingleton::getInstance()->getItem('ElNozha') ?? 0.0;
        $shippingSheraton  = SettingSingleton::getInstance()->getItem('Sheraton') ?? 0.0;
        $shippingShubra  = SettingSingleton::getInstance()->getItem('Shubra') ?? 0.0;
        $shippingMaadi  = SettingSingleton::getInstance()->getItem('Maadi') ?? 0.0;
        $shippingHelwan  = SettingSingleton::getInstance()->getItem('Helwan') ?? 0.0;
        $shippingElRehab  = SettingSingleton::getInstance()->getItem('ElRehab') ?? 0.0;
        $shippingMadinaty  = SettingSingleton::getInstance()->getItem('Madinaty') ?? 0.0;
        $shippingTheFifthSettlement  = SettingSingleton::getInstance()->getItem('The_fifth_settlement') ?? 0.0;
           $shippingGiza  = SettingSingleton::getInstance()->getItem('Giza') ?? 0.0;
        $shippingDokki  = SettingSingleton::getInstance()->getItem('Dokki') ?? 0.0;
        $shippingMohandessin  = SettingSingleton::getInstance()->getItem('Mohandessin') ?? 0.0;
        $shippingAgouza  = SettingSingleton::getInstance()->getItem('Agouza') ?? 0.0;
        $shippingImbaba  = SettingSingleton::getInstance()->getItem('Imbaba') ?? 0.0;
        $shippingFaisal  = SettingSingleton::getInstance()->getItem('Faisal') ?? 0.0;
        $shipping6th_of_October_City  = SettingSingleton::getInstance()->getItem('6th_of_October_City') ?? 0.0;
        $shippingSheikh_Zayed  = SettingSingleton::getInstance()->getItem('Sheikh_Zayed') ?? 0.0;
        $shippingHaram  = SettingSingleton::getInstance()->getItem('Haram') ?? 0.0;
        $shippingRates = [
            // 'cairo' => $shippingCairo,
            // 'giza'  => $shippingGiza,
            'downtown' => $shippingDowntown,
            'zamalek' => $shippingZamalek,
            'garden_city' => $shippingGardenCity,
            'elmanial' => $shippingElManial,
            'nasr_city' => $shippingNasrCity,
            'heliopolis' => $shippingHeliopolis,
            'abbassia' => $shippingAbbassia,
            'roxy' => $shippingRoxy,
            'el_nozha' => $shippingElNozha,
            'sheraton' => $shippingSheraton,
            'shubra' => $shippingShubra,
            'maadi' => $shippingMaadi,
            'helwan' => $shippingHelwan,
            'el_rehab' => $shippingElRehab,
            'madinaty' => $shippingMadinaty,
            'the_fifth_settlement' => $shippingTheFifthSettlement,
            'Giza' => $shippingGiza,
            'Dokki' => $shippingDokki,
            'Mohandessin' => $shippingMohandessin,
            'Agouza' => $shippingAgouza,
            'Imbaba' => $shippingImbaba,
            'Faisal' => $shippingFaisal,
            '6th_of_October_City' => $shipping6th_of_October_City,
            'Sheikh_Zayed' => $shippingSheikh_Zayed,
            'Haram' => $shippingHaram,

        ];
        $shippingCost = $shippingRates[$governorate] ?? 0;

        $taxRate = SettingSingleton::getInstance()->getItem('tax') ?? 0;

        $coupon   = session('coupon', null);
        $discount = $coupon['amount'] ?? 0;

        $threshold = SettingSingleton::getInstance()->getUpperNotify('upper_price') ?? 0;

        if ($discount == 0 && $subTotal > $threshold) {
            $shippingCost = 0;
        }

        $netAfterDiscount = max(0, $subTotal - $discount);
        $taxableAmount    = $netAfterDiscount + $shippingCost;
        $taxAmount        = $taxableAmount * $taxRate;
        $finalTotal       = $taxableAmount + $taxAmount;

        $user = User::firstOrCreate(
            ['email' => $validated['sender_email']],
            [
                'name'     => $validated['sender_name'],
                'mobile'   => $validated['sender_mobile'],
                'password' => bcrypt('temp_password'),
            ]
        );

        $receiptImagePath = null;
        foreach ($request->allFiles() as $key => $file) {
            if (strpos($key, 'receipt_image_') === 0 && $file->isValid()) {
                $destination   = public_path(Order::staticPath());
                $imageName     = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $imageName);
                $receiptImagePath = $imageName;
                break;
            }
        }

        $address = implode(', ', [
            $validated['st_name'],
            $validated['apartment'],
            $validated['floor'],
            $validated['area'],
        ]);

        $identifier = time() . rand(1000, 9999);
        $order = Order::create([
            'identifier'        => $identifier,
            'customer_name'     => $user->name,
            'customer_mobile'   => $user->mobile,
            'customer_email'    => $user->email,
            'total_quantity'    => $carts->sum('quantity'),
            'payment_method_id' => PaymentMethod::where('unique_name', $validated['payment_method'])->first()->id,
            'status'            => 'pending',
            'total'             => $finalTotal,
            'promo_code_id'     => $coupon['id'] ?? null,
            'discount'          => $discount,
            'address'           => $address,
            'created_by'        => $user->id,
            'image'             => $receiptImagePath,
        ]);

        DeliveryDetails::create([
            'st_name'           => $validated['st_name'],
            'apartment'         => $validated['apartment'],
            'floor'             => $validated['floor'],
            'area'              => $validated['area'],
            'order_id'          => $order->id,
            'shipping_cost'     => $shippingCost,
            'total'             => $finalTotal,
            'payment_method_id' => $order->payment_method_id,
            'status'            => 1,
        ]);

        foreach ($carts as $cart) {
            OrderDetail::create([
                'order_id'         => $order->id,
                'product_id'       => $cart->product_id,
                'product_name'     => $cart->product_name ?? $cart->product->name,
                'price'            => $cart->price,
                'price_after_sale' => $cart->price_after_sale ?? $cart->price,
                'quantity'         => $cart->quantity,
                'total'            => $cart->total_price,
                'user_input'       => $cart->user_input,
                'created_by'       => $user->id,
            ]);
        }

        ReceipentsDetails::create([
            'order_id' => $order->id,
            'name'     => $validated['recipient_first_name'] . ' ' . $validated['recipient_last_name'],
            'mobile'   => $validated['recipient_mobile'],
            'address'  => $address,
        ]);

        OrderExtraDetails::create([
            'order_id'                   => $order->id,
            'extra_instructions'         => $validated['extra_instructions'],
            'greeting_card'              => $validated['greeting_card'],
            'same_day'                   => $validated['delivery_option'] === 'same_day',
            'delivery_date'              => $validated['delivery_option'] === 'same_day'
                ? now()->toDateString()
                : $validated['delivery_date'],
            'specific_time_slot_status'  => $validated['delivery_option'] === 'schedule',
            'specific_time'              => $validated['delivery_option'] === 'schedule'
                ? $validated['delivery_time']
                : null,
        ]);

        Cart::where('cart_group_id', $cartGroup->id)->delete();
        session()->forget('coupon');

        return redirect()->route('site.cart')
            ->with('success', 'Order has been placed successfully.');
    }
}

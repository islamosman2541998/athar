<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Livewire\Component;
use App\Models\CartGroup;
use App\Models\PromoCode;
use App\Settings\SettingSingleton;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class ApplyCoupon extends Component
{
    public $code;
    public $discountAmount = 0;
    public $message = '';
    public $carts;
    public $governorate = '';
    public $shippingRates;
    public $subtotal;
    public $taxRate;

    public function mount($subtotal, $taxRate, $carts)
    {
        $this->subtotal = $subtotal;
        $this->taxRate  = $taxRate;
        $this->carts    = collect($carts);

        // $shippingCairo = SettingSingleton::getInstance()->getItem('shipping_cairo') ?? 0.0;
        // $shippingGiza  = SettingSingleton::getInstance()->getItem('shipping_giza') ?? 0.0;
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

        $this->shippingRates = [
            // 'cairo' => $shippingCairo,
            // 'giza'  => $shippingGiza,
            'Downtown' => $shippingDowntown,
            'Zamalek' => $shippingZamalek,
            'Garden_City' => $shippingGardenCity,
            'ElManial' => $shippingElManial,
            'Nasr_City' => $shippingNasrCity,
            'Heliopolis' => $shippingHeliopolis,
            'Abbassia' => $shippingAbbassia,
            'Roxy' => $shippingRoxy,
            'ElNozha' => $shippingElNozha,
            'Sheraton' => $shippingSheraton,
            'Shubra' => $shippingShubra,
            'Maadi' => $shippingMaadi,
            'Helwan' => $shippingHelwan,
            'ElRehab' => $shippingElRehab,
            'Madinaty' => $shippingMadinaty,
            'The_fifth_settlement' => $shippingTheFifthSettlement,
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



        Session::put('governorate', $this->governorate);
    }

    public function updatedGovernorate($value)
    {
        $this->governorate = $value;
        $price = SettingSingleton::getInstance()->getItem($this->governorate);
        // dd( $price, $this->governorate);
        Session::put('governorate', $this->governorate);
    }


    public function getShippingCostProperty()
    {
        $original  = $this->shippingRates[$this->governorate] ?? 0;
        $threshold = SettingSingleton::getInstance()->getUpperNotify('upper_price') ?? 0;

        if ($this->discountAmount == 0 && $this->subtotal > $threshold) {
            return 0;
        }

        return $original;
    }

   public function applyCode()
{
    $cookie    = Cookie::get('cart_cookie');
    $cartGroup = CartGroup::where('cookeries', $cookie)->first();
    $carts     = $cartGroup
        ? Cart::with('product.categories')
              ->where('cart_group_id', $cartGroup->id)
              ->get()
        : collect();

    $entered = trim($this->code);
    $promo   = PromoCode::with('categories')
        ->whereRaw('LOWER(code)=?', [strtolower($entered)])
        ->where('status', 1)
        ->where('uses_left', '>', 0)
        ->where('start_at', '<=', now())
        ->where('end_at', '>=', now())
        ->first();

    if (! $promo) {
        $this->discountAmount = 0;
        $this->message        = __('messages.invalid_or_expired_coupon');
        Session::forget('coupon');
        return;
    }

    $allowedIds = $promo->categories->pluck('id')->toArray();

    $eligibleItems = $carts->filter(fn($item) =>
        $item->product->categories->pluck('id')->intersect($allowedIds)->isNotEmpty()
    );

    if ($eligibleItems->isEmpty()) {
        $this->discountAmount = 0;
        $this->message        = __('messages.invalid_or_expired_coupon');
        Session::forget('coupon');
        return;
    }

    $eligibleTotal = $eligibleItems->sum('total_price');

    if ($promo->type === 'fixed') {
        $this->discountAmount = min($promo->value, $eligibleTotal);
    } else {
        $this->discountAmount = ($eligibleTotal * $promo->value) / 100;
    }

    $promo->decrement('uses_left');
    if ($promo->uses_left <= 0) {
        $promo->status = 0;
        $promo->save();
    }
 
    Session::put('coupon', [
        'id'     => $promo->id,
        'amount' => $this->discountAmount,
    ]);

    $this->message = __('messages.coupon_applied_success', [
        'amount' => number_format($this->discountAmount, 2)
    ]);
}

    public function render()
    {
        $shippingCost = $this->shippingCost;
        $taxable      = $this->subtotal - $this->discountAmount + $shippingCost;
        $taxAmount    = $taxable * $this->taxRate;
        $finalTotal   = $taxable + $taxAmount;



        return view('livewire.apply-coupon', [
            'shippingCost' => $shippingCost,
            'taxAmount'    => $taxAmount,
            'finalTotal'   => $finalTotal,
        ]);
    }
}

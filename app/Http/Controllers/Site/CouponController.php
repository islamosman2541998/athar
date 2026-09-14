<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;

class CouponController extends Controller
{
    /**
 
     */
    public function getWelcomeCoupon()
    {
        return PromoCode::active()
                        ->valid()
                        ->with('transNow')  
                        ->inRandomOrder()    
                        ->first();
    }
}

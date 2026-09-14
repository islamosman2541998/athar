<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $methods = PaymentMethod::active()->get();
        if(!$methods){
            return $this->notFoundResponse();
        }
        return $this->success(PaymentMethodResource::collection($methods) , '' , 200);
    }
}

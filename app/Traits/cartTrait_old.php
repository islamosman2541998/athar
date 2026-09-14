<?php


namespace App\Traits;


use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartGroup;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

trait cartTrait_old
{

    /*###################start#######################*/

    public function addItem2(Request $attributes, $name, $quantity = 1, $price = 0)
    {

        if ($quantity <= 0) {
            return ['data' => ['cart' => null, 'type' => 'warning', 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => __('The donation value must be greater than zero'), 'code' => 400];
        }

        $cookieValue = $attributes->cookie($name); //here
        if (!$this->checkCookie($attributes, $name)['exists'] || $attributes->cookie($name) == null) {
            $cookieValue = $attributes->cookie($name, Str::random(30));
        }

        $cart = Cart::where('cookeries', $cookieValue)
            ->where('cookeries', '<>', null)
            ->where('product_id', $attributes['product_id'])
//            ->where('product_name', $attributes['product_name'])
            ->first();

        if (!$cart) {  // create item
            $cart = Cart::create([
                'cookeries' => $cookieValue,
                'product_id' => $attributes['product_id'] ?? null,
                'product_name' => $attributes['product_name'] ?? null,
            ]);

        }

        $cart->quantity = $cart->quantity + $quantity;
        $cart->price = $price;
        $cart->total = +($cart->total ?? 0) + ($price * $quantity);
        $cart->user_id = auth()->id ?? null;
        $cart->save();

        $cart->id;

        return ['data' => ['cart' =>  new cartResource($cart), 'type' => 'success' , 'cookie_name' => 'cart', 'cookie_value' => $cookieValue], 'message' => __('success'), 'code' => 200 ];
    }


    public function showCart($name)
    {
        $cart = Cart::where('cookeries', \request()->cookie($name))->get();

        if (!$cart) {
            return ['data' => ['cart' => null, 'type' => 'warning'  , 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => trans('cart is empty '), 'code' => 404 ];
        }
        return ['data' => ['cart' =>    cartResource::collection($cart) , 'type' => 'success' , 'cookie_name' => 'cart', 'cookie_value' => \request()->cookie($name)], 'message' => __('success'), 'code' => 200 ];
    }




    public function showCartByParam($param )
    {
        $cart = Cart::where('cookeries', $param)->get();

        if (!$cart) {
            return ['data' => ['cart' => null, 'type' => 'warning'  , 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => trans('cart is empty '), 'code' => 404 ];
        }
        return ['data' => ['cart' =>    cartResource::collection($cart) , 'type' => 'success' , 'cookie_name' => 'cart', 'cookie_value' => $param], 'message' => __('success'), 'code' => 200 ];
    }



    /*###################end#######################*/


    public function plusQty(Request $attributes, $name, $quantity)
    {

        if ($quantity <= 0) {
            return ['data' => ['cart' => null, 'type' => 'warning', 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => __('The donation value must be greater than zero'), 'code' => 400];
        }

        $cookieValue = $attributes->cookie($name); //here

        if (!$cookieValue) {
            return ['data' => ['cart' => null, 'type' => 'warning' , 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => trans('please enter item in cart first, '), 'code' => 404 ];
        }


        $cart = Cart::where('cookeries', $cookieValue)->
        where('cookeries', '<>', null)->
        where('id', $attributes['cart_id'])
            ->first();


        if (!$cart) {  // create item
            return ['data' => ['cart' => null, 'type' => 'warning' , 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => trans('please enter item in cart first, '), 'code' => 404 ];


        } else {  // update item
            $cart->total = ($cart->quantity + $quantity) * $cart->price;
            $cart->quantity = $cart->quantity + $quantity;
            $cart->save();
        }


        $attributes['cart_id'] = $cart->id;


        return ['data' => ['cart' =>  new cartResource($cart), 'type' => 'success' , 'cookie_name' => 'cart', 'cookie_value' => $cookieValue], 'message' => trans('The Quantity has been successfully increased in the basket'), 'code' => 200 ];

    }


    public function minusQty(Request $attributes, $name, $quantity)
    {

        if ($quantity <= 0) {
            return ['data' => ['cart' => null, 'type' => 'warning', 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => __('The donation value must be greater than zero'), 'code' => 400];

        }

        $cookieValue = $attributes->cookie($name); //here

        if (!$cookieValue) {
            return ['data' => ['cart' => null, 'type' => 'warning' , 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => trans('please enter item in cart first, '), 'code' => 404 ];

        }



        $cart = Cart::where('cookeries', $cookieValue)
            ->where('cookeries', '<>', null)->
            where('id', $attributes['cart_id'])
            ->first();


        if (!$cart) {  // create item
            return ['data' => ['cart' =>  new cartResource($cart), 'type' => 'warning' , 'cookie_name' => 'cart', 'cookie_value' => $cookieValue], 'message' => trans('please enter item in cart first,'), 'code' => 404 ];


        } else {  // update item
            if ($cart->quantity - $quantity < 1) {
                return ['data' => ['cart' =>  new cartResource($cart), 'type' => 'warning' , 'cookie_name' => 'cart', 'cookie_value' => $cookieValue], 'message' => trans('quantity must be more than 0, '), 'code' => 400 ];

            }
            $cart->total = ($cart->quantity - $quantity) * $cart->price;
            $cart->quantity = $cart->quantity - $quantity;
            $cart->save();
        }


        return ['data' => ['cart' =>  new cartResource($cart), 'type' => 'success' , 'cookie_name' => 'cart', 'cookie_value' => $cookieValue], 'message' => trans('The Quantity has been successfully decreased in the basket'), 'code' => 200 ];

    }

    /*###################end#######################*/


    // Method to set a cookie
    public function setCookie(Request $request, $name, $repeatStatus = 0, $val = null, $attr = null)
    {

        $minutes = 5; // Duration in minutes
        Cookie::queue($name, 'basma', $minutes);
        Cookie::queue(Cookie::forget($name));
        Cookie::queue(Cookie::make($name, '$request->ip()', $minutes));
        $val = $request->cookie($name);

        if ($repeatStatus === 0) {
            return response($attr ?? 'Cookie has been set')->withCookie(cookie($name, $val, $minutes));
        } else {
            return response($attr ?? 'Cookie has been set')->withCookie(cookie($name, $val, $minutes));
        }
    }

    // Method to get a cookie
    public function getCookie(Request $request, $name)
    {
        $cookieValue = $request->cookie($name);
        return response()->json([$name => $cookieValue]);
    }



    // Method to delete a cookie
    public function deleteCookie($name, $request)
    {
        $group = Cart::where('cookeries', \request()->cookie($name))->where('cookeries', '<>', null)->get();

        if ($group->first() == null) { //here
            return ['data' => ['cart' => null, 'type' => 'warning' , 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => trans('your cart is already empty,'), 'code' => 404 ];
        }
        foreach ($group as $item) {
            $item->delete();
        }
        Cookie::forget($name);
        return ['data' => ['cart' => null, 'type' => 'success' , 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => trans('Cart is empty Now,'), 'code' => 201 ];
    }




    public function deleteItem($name, $request)
    {
        $cart = Cart::where('cookeries', \request()->cookie($name))->where('id', $request->cart_id)->first();

        if (!$cart) {
            return ['data' => ['cart' => null, 'type' => 'warning' , 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => trans('product is already not found ,'), 'code' => 404 ];
        }

        $cart->delete();
        return ['data' => ['cart' => null, 'type' => 'success' , 'cookie_name' => 'cart', 'cookie_value' => null], 'message' => trans('product is deleted successfully '), 'code' => 201 ];
    }




    public function checkCookie(Request $request, $name)
    {
        // Check if the cookie exists
        if ($request->hasCookie($name)) {
            $cookieValue = $request->cookie($name); // Retrieve the cookie value
            return ['exists' => true, 'value' => $cookieValue];
        } else {
            return ['exists' => false];
        }
    }

    /*###################end############################*/


}

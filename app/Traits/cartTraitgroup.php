<?php


namespace App\Traits;


use App\Models\Cart;
use App\Models\CartGroup;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

trait cartTraitgroup
{

    /*###################start#######################*/

    public function addItem2($item, Request $attributes, $name, $quantity = 1, $price = 0, $new = false)
    {

        if ($quantity <= 0) {
            return [
                'type' => 'warning',
                'value' => __('The donation value must be greater than zero'),
            ];
        }

        $cookieValue = $attributes->cookie($name); //here

        if (!$this->checkCookie($attributes, $name)['exists'] || $attributes->cookie($name) == null) {
            $cookieValue = $attributes->cookie($name, Str::random(30));
        }

        $group = CartGroup::where('cookeies', $cookieValue)
            ->where('cookeies', '<>', null)
            ->first();


        $cart = $group && $group->id ? Cart::
        where('product_id', $attributes['product_id'])->
        where('product_name', $attributes['product_name'])->
        where('cart_group_id', $group->id)->first() : null;


        if (!$group && !$cart) {  // create item
            $group = CartGroup::create(['cookeies' => $cookieValue])->refresh();


            $cart = Cart::create([
                'product_id' => $attributes['product_id'] ?? null,
                'product_name' => $attributes['product_name'] ?? null,
                'quantity' => $quantity,
                'price' => $price,
                'total_price' => $price * $quantity,
                'user_id' => auth()->id ?? null,
                'cart_group_id' => $group->id,
            ]);

        } elseif ($group && $group->id && !$cart) {
            $cart = Cart::create([
                'product_id' => $attributes['product_id'] ?? null,
                'product_name' => $attributes['product_name'] ?? null,
                'quantity' => $quantity,
                'price' => $price,
                'total_price' => $price * $quantity,
                'user_id' => auth()->id ?? null,
                'cart_group_id' => $group->id,
            ]);

        } elseif ($group && $group->id && $cart && $cart->id) {  // update item
            $cart->total_price = ($cart->quantity + $quantity) * $cart->price;
            $cart->quantity = $cart->quantity + $quantity;
            $cart->save();
        }


        $attributes['card_id'] = $cart->id;


        return response()->json([
            'card_id' => $cart->id,
            'type' => 'success',
            'cookeies' => $cookieValue,
            'message' => trans('The project has been successfully added to the donation basket')
        ])->withCookie(cookie($name, $cookieValue, 5));
    }

    /*###################end#######################*/


    public function plusQty($item, Request $attributes, $name, $quantity)
    {

        if ($quantity <= 0) {
            return [
                'type' => 'warning',
                'value' => __('The Quantity must be greater than zero'),
            ];
        }

        $cookieValue = $attributes->cookie($name); //here

        if (!$cookieValue) {
            return response()->json([
                'card_id' => null,
                'type' => 'warning',
                'cookeies' => null,
                'message' => trans('please enter item in cart first, ')
            ])->withCookie(cookie($name, $cookieValue, 5));
        }

        if (!$this->checkCookie($attributes, $name)['exists'] || $attributes->cookie($name) == null) {
            $cookieValue = $attributes->cookie($name, Str::random(30));
        }


        $cart = Cart::whereHas('group', function ($q) use ($cookieValue) {
            $q->where('cookeies', $cookieValue)
                ->where('cookeies', '<>', null);
        })->
        where('product_id', $attributes['product_id'])
            ->first();


        if (!$cart) {  // create item
            return response()->json([
                'card_id' => null,
                'type' => 'warning',
                'cookeies' => null,
                'message' => trans('please enter item in cart first, ')
            ])->withCookie(cookie($name, $cookieValue, 5));

        } else {  // update item
            $cart->total_price = ($cart->quantity + $quantity) * $cart->price;
            $cart->quantity = $cart->quantity + $quantity;
            $cart->save();
        }


        $attributes['card_id'] = $cart->id;


        return response()->json([
            'card_id' => $cart->id,
            'type' => 'success',
            'cookeies' => $cookieValue,
            'message' => trans('The Quantity has been successfully increased in the basket')
        ])->withCookie(cookie($name, $cookieValue, 5));
    }


    public function minusQty($item, Request $attributes, $name, $quantity)
    {

        if ($quantity <= 0) {
            return [
                'type' => 'warning',
                'value' => __('The Quantity must be greater than zero'),
            ];
        }

        $cookieValue = $attributes->cookie($name); //here

        if (!$cookieValue) {
            return response()->json([
                'card_id' => null,
                'type' => 'warning',
                'cookeies' => null,
                'message' => trans('please enter item in cart first, ')
            ]);
        }

        if (!$this->checkCookie($attributes, $name)['exists'] || $attributes->cookie($name) == null) {
            $cookieValue = $attributes->cookie($name, Str::random(30));
        }


        $cart = Cart::whereHas('group', function ($q) use ($cookieValue) {
            $q->where('cookeies', $cookieValue)
                ->where('cookeies', '<>', null);
        })->
        where('product_id', $attributes['product_id'])
            ->first();


        if (!$cart) {  // create item
            return response()->json([
                'card_id' => null,
                'type' => 'warning',
                'cookeies' => null,
                'message' => trans('please enter item in cart first, ')
            ]);

        } else {  // update item
            $cart->total_price = ($cart->quantity - $quantity) * $cart->price;
            $cart->quantity = $cart->quantity - $quantity;
            $cart->save();
        }


        $attributes['card_id'] = $cart->id;


        return response()->json([
            'card_id' => $cart->id,
            'type' => 'success',
            'cookeies' => $cookieValue,
            'message' => trans('The Quantity has been successfully increased in the basket')
        ])->withCookie(cookie($name, $cookieValue, 5));
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
    public function deleteCookie($name)
    {
        $group = CartGroup::with('carts')->where('cookeies', \request()->cookie($name))->first();
        if (!$group) {
            return response()->json([
                'card_id' => null,
                'type' => 'warning',
                'cookeies' => null,
                'message' => trans('your cart is already empty ')
            ]);
        }
        if ($group->carts && $group->carts->count()) {
            $group->carts()->delete();
        }
        $group->delete();

        Cookie::forget($name);
        return response('Cart is empty Now')->withoutCookie($name);

    }


    public function deleteItem($name, $request)
    {
        $cart = Cart::whereHas('group', function ($q) use ($name) {
            $q->where('cookeies', \request()->cookie($name));
        })->first();

        if (!$cart) {
            return response()->json([
                'type' => 'warning',
                'cookeies' => null,
                'message' => trans('product is already not found ')
            ]);
        }

         $cart->delete();
        return response('product is removed from cart successfully')->withoutCookie($name);

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

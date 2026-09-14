<?php


namespace App\Traits;


use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

trait orderTrait
{

    /*###################start#######################*/
    public function addItem2($item, Request $attributes , $quantity, $name)
    {


        if ($quantity <= 0) {
            return [
                'type' => 'warning',
                'value' => __('The donation value must be greater than zero'),
            ];
        }

        // $cookieValue = $attributes->cookie($name); //here
        $cookieValue = $attributes->cart_cookie; 

//        if (!$this->checkCookie($attributes, $name)['exists'] || $attributes->cookie($name) == null) {
//            $cookieValue = $attributes->cookie($name, Str::random(30));
//        }

        $group = Order::where('cookies', $cookieValue)
            ->where('cookies', '<>', null)
            ->first();

        $OrderDetail = $group && $group->id ? OrderDetail::
        where('product_id', $attributes['product_id'])->
        where('product_name', $attributes['product_name'])->
        where('order_id', $group->id)->first() : null;


        $price_after_sale = $attributes['sale'] > 0 ? $attributes['price'] - ($attributes['price'] * $attributes['sale'] / 100) :  $attributes['price'];


        if (!$group && !$OrderDetail) {  // create item
            $group = new Order();

            $group -> cookies = $cookieValue;
            $group -> identifier = "O-" . Order::max('id') + 1 . Str::random(30);
            $group -> customer_name = $attributes['customer_name'];
            $group -> customer_mobile = $attributes['customer_mobile'];
            $group -> total = $attributes['total'];
            $group -> payment_method_id = $attributes['payment_method_id'];
            $group -> shipped_status = $attributes['shipped_status'];
            $group -> shipped_price = $attributes['shipped_price'];
            $group -> created_by = $attributes['created_by'];

            $group ->save();



            $OrderDetail = OrderDetail::create([
                'order_id' => $group->id,
                'product_id' => $attributes['product_id'] ?? null,
                'product_name' => $attributes['product_name'] ?? null,
                'price' => $attributes['price'],
                'sale' => $attributes['sale'],
                'price_after_sale' => $price_after_sale ,
                'quantity' => $attributes['quantity'],
                'total' => $price_after_sale * $attributes['quantity'],
                'refund_status' => $attributes['refund_status'],
            ]);

        } elseif ($group && $group->id && !$OrderDetail) {
            $OrderDetail = OrderDetail::create([
                'order_id' => $group->id,
                'product_id' => $attributes['product_id'] ?? null,
                'product_name' => $attributes['product_name'] ?? null,
                'price' => $attributes['price'],
                'sale' => $attributes['sale'],
                'price_after_sale' => $price_after_sale ,
                'quantity' => $attributes['quantity'],
                'total' => $price_after_sale * $attributes['quantity'],
                'refund_status' => $attributes['refund_status'],
            ]);



        } elseif ($group && $group->id && $OrderDetail && $OrderDetail->id) {  // update item
            $OrderDetail->total = ($OrderDetail->quantity +  $attributes['quantity']) * $OrderDetail->price;
            $OrderDetail->quantity = $OrderDetail->quantity +  $attributes['quantity'];
            $OrderDetail->save();
        }


        $attributes['card_id'] = $OrderDetail->id;


        return response()->json([
            'card_id' => $OrderDetail->id,
            'type' => 'success',
            'cookies' => $cookieValue,
            'message' => trans('The project has been successfully added to the donation basket')
        ])->withCookie(cookie($name, $cookieValue, 5));
    }

//    public function addItem2($item, Request $attributes , $quantity, $name)
//    {
//
//
//        if ($quantity <= 0) {
//            return [
//                'type' => 'warning',
//                'value' => __('The donation value must be greater than zero'),
//            ];
//        }
//
//        $cookieValue = $attributes->cookie($name); //here
//
////        if (!$this->checkCookie($attributes, $name)['exists'] || $attributes->cookie($name) == null) {
////            $cookieValue = $attributes->cookie($name, Str::random(30));
////        }
//
//        $group = Order::where('cookies', $cookieValue)
//            ->where('cookies', '<>', null)
//            ->first();
//
//        $OrderDetail = $group && $group->id ? OrderDetail::
//        where('product_id', $attributes['product_id'])->
//        where('product_name', $attributes['product_name'])->
//        where('order_id', $group->id)->first() : null;
//
//
//        $price_after_sale = $attributes['sale'] > 0 ? $attributes['price'] - ($attributes['price'] * $attributes['sale'] / 100) :  $attributes['price'];
//
//
//        if (!$group && !$OrderDetail) {  // create item
//            $group = new Order();
//
//            $group -> cookies = $cookieValue;
//            $group -> identifier = "O-" . Order::max('id') + 1 . Str::random(30);
//            $group -> customer_name = $attributes['customer_name'];
//            $group -> customer_mobile = $attributes['customer_mobile'];
//            $group -> total = $attributes['total'];
//            $group -> payment_method_id = $attributes['payment_method_id'];
//            $group -> shipped_status = $attributes['shipped_status'];
//            $group -> shipped_price = $attributes['shipped_price'];
//            $group -> created_by = $attributes['created_by'];
//
//            $group ->save();
//
//
//
//            $OrderDetail = OrderDetail::create([
//                'order_id' => $group->id,
//                'product_id' => $attributes['product_id'] ?? null,
//                'product_name' => $attributes['product_name'] ?? null,
//                'price' => $attributes['price'],
//                'sale' => $attributes['sale'],
//                'price_after_sale' => $price_after_sale ,
//                'quantity' => $attributes['quantity'],
//                'total' => $price_after_sale * $attributes['quantity'],
//                'refund_status' => $attributes['refund_status'],
//            ]);
//
//        } elseif ($group && $group->id && !$OrderDetail) {
//            $OrderDetail = OrderDetail::create([
//                'order_id' => $group->id,
//                'product_id' => $attributes['product_id'] ?? null,
//                'product_name' => $attributes['product_name'] ?? null,
//                'price' => $attributes['price'],
//                'sale' => $attributes['sale'],
//                'price_after_sale' => $price_after_sale ,
//                'quantity' => $attributes['quantity'],
//                'total' => $price_after_sale * $attributes['quantity'],
//                'refund_status' => $attributes['refund_status'],
//            ]);
//
//
//
//        } elseif ($group && $group->id && $OrderDetail && $OrderDetail->id) {  // update item
//            $OrderDetail->total = ($OrderDetail->quantity +  $attributes['quantity']) * $OrderDetail->price;
//            $OrderDetail->quantity = $OrderDetail->quantity +  $attributes['quantity'];
//            $OrderDetail->save();
//        }
//
//
//        $attributes['card_id'] = $OrderDetail->id;
//
//
//        return response()->json([
//            'card_id' => $OrderDetail->id,
//            'type' => 'success',
//            'cookies' => $cookieValue,
//            'message' => trans('The project has been successfully added to the donation basket')
//        ])->withCookie(cookie($name, $cookieValue, 5));
//    }

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
                'cookies' => null,
                'message' => trans('please enter item in OrderDetail first, ')
            ])->withCookie(cookie($name, $cookieValue, 5));
        }

        if (!$this->checkCookie($attributes, $name)['exists'] || $attributes->cookie($name) == null) {
            $cookieValue = $attributes->cookie($name, Str::random(30));
        }


        $OrderDetail = OrderDetail::whereHas('group', function ($q) use ($cookieValue) {
            $q->where('cookies', $cookieValue)
                ->where('cookies', '<>', null);
        })->
        where('product_id', $attributes['product_id'])
            ->first();


        if (!$OrderDetail) {  // create item
            return response()->json([
                'card_id' => null,
                'type' => 'warning',
                'cookies' => null,
                'message' => trans('please enter item in OrderDetail first, ')
            ])->withCookie(cookie($name, $cookieValue, 5));

        } else {  // update item
            $OrderDetail->total_price = ($OrderDetail->quantity + $quantity) * $OrderDetail->price;
            $OrderDetail->quantity = $OrderDetail->quantity + $quantity;
            $OrderDetail->save();
        }


        $attributes['card_id'] = $OrderDetail->id;


        return response()->json([
            'card_id' => $OrderDetail->id,
            'type' => 'success',
            'cookies' => $cookieValue,
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
                'cookies' => null,
                'message' => trans('please enter item in OrderDetail first, ')
            ]);
        }

        if (!$this->checkCookie($attributes, $name)['exists'] || $attributes->cookie($name) == null) {
            $cookieValue = $attributes->cookie($name, Str::random(30));
        }


        $OrderDetail = OrderDetail::whereHas('group', function ($q) use ($cookieValue) {
            $q->where('cookies', $cookieValue)
                ->where('cookies', '<>', null);
        })->
        where('product_id', $attributes['product_id'])
            ->first();


        if (!$OrderDetail) {  // create item
            return response()->json([
                'card_id' => null,
                'type' => 'warning',
                'cookies' => null,
                'message' => trans('please enter item in OrderDetail first, ')
            ]);

        } else {  // update item
            $OrderDetail->total_price = ($OrderDetail->quantity - $quantity) * $OrderDetail->price;
            $OrderDetail->quantity = $OrderDetail->quantity - $quantity;
            $OrderDetail->save();
        }


        $attributes['card_id'] = $OrderDetail->id;


        return response()->json([
            'card_id' => $OrderDetail->id,
            'type' => 'success',
            'cookies' => $cookieValue,
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
        $group = Order::with('OrderDetails')->where('cookies', \request()->cookie($name))->first();
        if (!$group) {
            return response()->json([
                'card_id' => null,
                'type' => 'warning',
                'cookies' => null,
                'message' => trans('your OrderDetail is already empty ')
            ]);
        }
        if ($group->OrderDetails && $group->OrderDetails->count()) {
            $group->OrderDetails()->delete();
        }
        $group->delete();

        Cookie::forget($name);
        return response('OrderDetail is empty Now')->withoutCookie($name);

    }


    public function deleteItem($name, $request)
    {
        $OrderDetail = OrderDetail::whereHas('group', function ($q) use ($name) {
            $q->where('cookies', \request()->cookie($name));
        })->first();

        if (!$OrderDetail) {
            return response()->json([
                'type' => 'warning',
                'cookies' => null,
                'message' => trans('product is already not found ')
            ]);
        }

        $OrderDetail->delete();
        return response('product is removed from OrderDetail successfully')->withoutCookie($name);

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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsOfCartOnly;
use App\Models\Cart;
use App\Models\CartGroup;
use App\Models\Product;
use App\Traits\cartTrait;
use Illuminate\Http\Request;


class CartController extends Controller
{
    use cartTrait;


    public function index(Request $request)
    {
        $cookie = $request->cart_cookie;
        if (!$cookie) return $this->notFoundResponse(__('message.carts.empty_cart_message'));
        $cart = Cart::where('cookeries', $cookie)->get();
        return $this->success(cartResource::collection($cart), '', 200);
    }




    public function showCartFunc()
    {
        $returned_val = $this->showCart('cart_cookie');
        if ($returned_val['data']['cart']->first() == null) {
            return $this->notFoundResponse(__('message.carts.empty_cart_message'));
        }

        /**************************/

        $items = Product::select('id' , 'image' , 'price_after_sale' , 'sale' , 'price'  , 'in_stock' )->with('transNow:id,title')->showincart()->active()->orderBy('sort', 'ASC')->get();
        $returned_val['data']['show_in_cart_products'] = ProductsOfCartOnly::collection($items);

        /****************************/

        return $this->successWithCookie($returned_val['data'], $returned_val['message'], $returned_val['code']);
    }




    public function showCartFuncByParam(Request $request)
    {
        $returned_val = $this->showCartByParam($request->cart_param);
        if ($returned_val['data']['cart']->first() == null) {
            return $this->notFoundResponse(__('message.carts.empty_cart_message'));
        }
        /**************************/

//        $items = Product::with('transNow', 'galleryGroup.images')->showincart()->active()->orderBy('sort', 'ASC')->get();
        $items = Product::select('id' , 'image' , 'price_after_sale' , 'sale' , 'price'  , 'in_stock' )->with('transNow:id,title')->showincart()->active()->orderBy('sort', 'ASC')->get();

        $returned_val['data']['show_in_cart_products'] = ProductsOfCartOnly::collection($items);

        /****************************/

        return $this->successWithCookie($returned_val['data'], $returned_val['message'], $returned_val['code']);
    }




    public function store(CartRequest $request)
    {
        $returned_val = $this->addItem2($request, "cart_cookie", $request->quantity, $request->price, 'cart');
        if (empty($returned_val['data']['cart'])) {
            return $this->notFoundResponse();
        }

        /**************************/

//        $items = Product::with('transNow', 'galleryGroup.images')->showincart()->active()->orderBy('sort', 'ASC')->get();
        $items = Product::select('id' , 'image' , 'price_after_sale' , 'sale' , 'price'  , 'in_stock' )->with('transNow:id,title')->showincart()->active()->orderBy('sort', 'ASC')->get();

        $returned_val['data']['show_in_cart_products'] = ProductsOfCartOnly::collection($items);

        /****************************/

        return $this->successWithCookie($returned_val['data'], $returned_val['message'], $returned_val['code']);
    }




    public function plusQtyFunc(Request $request)
    {
        $returned_val = $this->plusQty($request, "cart_cookie", $request->quantity ?? 1);
        if (empty($returned_val['data']['cart'])) {
            return $this->notFoundResponse();
        }
        return $this->successWithCookie($returned_val['data'], $returned_val['message'], $returned_val['code']);
    }




    public function minusQtyFunc(Request $request)
    {
        $returned_val = $this->minusQty($request, "cart_cookie", $request->quantity ?? 1);
        if (empty($returned_val['data']['cart'])) {
            return $this->notFoundResponse();
        }
        return $this->successWithCookie($returned_val['data'], $returned_val['message'], $returned_val['code']);
    }




    public function deleteCart(Request $request)
    {
        $returned_val = $this->deleteCookie('cart_cookie', $request);
        if ($returned_val['code'] == 404) {
            return $this->notFoundResponse();
        }
        return $this->successWithCookie($returned_val['data'], $returned_val['message'], $returned_val['code']);
    }




    public function deleteItemFromCart(Request $request)
    {
        $returned_val = $this->deleteItem($request);


        if ($returned_val['code'] == 404) {
            return $this->notFoundResponse();
        }

        $cart = Cart::with('product:id,image')->where('cookeries', $request->cart_cookie)->get();
        $returned_val['data']['total'] = $cart->sum('total');
        $returned_val['data']['sum_of_quantity'] = $cart->sum('quantity');


        return $this->successWithCookie($returned_val['data'], $returned_val['message'], $returned_val['code']);
    }




    public function cartIems(Request $request)
    {
        $cart = Cart::where('cookeries', $request->cart)->get();

        if ($cart == null) {
            return $this->notFoundResponse(__('message.carts.empty_cart_message'));
        }

        return $this->success(cartResource::collection($cart), "", 200);

    }



    public function updateQty(Request $request)
    {
        $single_cart = Cart::find($request->cart_id);
        if ($single_cart == null) {
            return $this->notFoundResponse(__('No item found'));
        }
        $single_cart->update(['quantity' => $request->quantity, 'total' => ($request->quantity * $single_cart->price)]);
        $carts = Cart::with('product:id,image')->where('cookeries', \request()->cart_cookie)->get();

        $data['quantity'] = $single_cart->quantity;
        $data['total'] = $carts->sum('total');
        $data['cart_quantity'] = $carts->sum('quantity');

//        $data['count'] = $cart->count();
        return $this->success($data, trans('message.carts.The Quantity updated successfully'), 200);

    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatusEnum;
use App\Enums\ShippingEnum;
use App\Events\OrderEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderShippingStatusResource;
use App\Http\Resources\PromoCodeResource;
use App\Models\Cart;
use App\Models\CartGroup;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\ShippingOrderStatus;
use App\Traits\cartTrait;
use App\Traits\orderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public $orderPath;


    public function __construct()
    {

        $this->orderPath = Order::staticPath();
    }



    public function show($id)
    {
        $order = Order::with('orderDetails')->find($id);
        if (!$order) {
            return $this->notFoundResponse();
        }
        return $this->success(new OrderResource($order), __('success'), 200);
    }


    public function showByCookie(Request $request)
    {

        if (!$request->cookie('order')) {
            return $this->notFoundResponse();
        }


        $order = Order::with('orderDetails')
            ->where('unique_order_cookies', $request->cookie('order'))
            ->where('unique_order_cookies', '<>', null)
            ->first();

        if (!$order) {
            return $this->notFoundResponse();
        }

        return $this->success(new OrderResource($order), __('success'), 200);
    }


    public function deleteOrderByCookie(Request $request)
    {
        if (!$request->cookie('order')) {
            return $this->notFoundResponse();
        }

        $order = Order::with('orderDetails')
            ->where('unique_order_cookies', $request->cookie('order'))
            ->where('unique_order_cookies', '<>', null)
            ->first();

        if (!$order) {
            return $this->notFoundResponse();
        }
        if ($order->orderDetails && $order->orderDetails->count()) {
            $order->orderDetails()->delete();
        }
        $order->delete();
        Cookie::forget('order');
        return $this->success([], __('messages.site.deleted_successfully'), 201);
    }


    public function deleteOrderById($id)
    {
        $order = Order::with('orderDetails')->find($id);
        if (!$order) {
            return $this->notFoundResponse();
        }
        if ($order->orderDetails && $order->orderDetails->count()) {
            $order->orderDetails()->delete();
        }
        $order->delete();
        if (\request()->cookie('order')) {
            Cookie::forget('order');
        }
        return $this->success([], __('message.deleted_successfully'), 201);
    }


    public function getCustomerCookies(Request $request)
    {
        if (!$request->cookie('customer_info')) {
            return $this->notFoundResponse();
        }
        $data = ['data' => ['cookie_name' => 'customer_info', 'cookie_value' => $request->cookie('customer_info')], 'message' => __('success'), 'code' => 200];
        return $this->successWithCookie($data['data'], $data['message'], $data['code']);
    }


    public function showShippingStatusByCookie(Request $request)
    {


        $statuses = ShippingOrderStatus::whereHas('order', function ($q) use ($request) {
            $q->where('unique_order_cookies', $request->order_cookie);
        })
            ->select('shipped_status', 'created_at')
            ->get();
        if (!$statuses || $statuses->count() < 1) {
            return $this->notFoundResponse();
        }
        return $this->success(OrderShippingStatusResource::collection($statuses), '', 200);

    }


    public function showShippingStatusById(Request $request)
    {
        $statuses = ShippingOrderStatus::where('order_id', $request->id)
            ->select('shipped_status', 'created_at')
            ->get();
        if (!$statuses || $statuses->count() < 1) {
            return $this->notFoundResponse();
        }
        return $this->success(OrderShippingStatusResource::collection($statuses), '', 200);

    }


    public function showShippingStatusByIdentifier(Request $request, $identifier)
    {
        $statuses = ShippingOrderStatus::whereHas('order', function ($q) use ($identifier) {
            $q->where('identifier', $identifier);
        })
            ->select('shipped_status', 'created_at')
            ->get();
        if (!$statuses || $statuses->count() < 1) {
            return $this->notFoundResponse();
        }
        return $this->success(OrderShippingStatusResource::collection($statuses), '', 200);

    }


    public function ShoWPromoCodes()
    {
        $promocodes = PromoCode::active()->valid()->get();
        if (!$promocodes) {
            return $this->notFoundResponse('admin.no_promo_codes_found');
        }
        return $this->success(PromoCodeResource::collection($promocodes), '', 200);
    }

}

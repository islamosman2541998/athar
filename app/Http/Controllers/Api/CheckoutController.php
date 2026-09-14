<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatusEnum;
use App\Enums\ShippingEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Orders\CheckOutRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\DeliveryDetails;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderExtraDetails;
use App\Models\OrderStatus;
use App\Models\PromoCode;
use App\Models\ReceipentsDetails;
use App\Models\ShippingOrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function newCheckout(CheckOutRequest $request)
    {
        $promo = PromoCode::active()->valid()->where('code' , $request->promo_code)->first();

        DB::beginTransaction();  // Start the transaction

        try {
            $carts = Cart::where('cookeries', request()->cart_cookie)->get();
            $total = array_sum($carts->pluck('total')->toArray()) ?? 0;
            if (count($carts) == 0) {
                return $this->notFoundResponse(__("message.carts.empty_cart_message"));
            }
            $encodedInputs = json_encode([
                'customer_name' => $request->customer_first_name . ' ' . $request->customer_second_name,
                'customer_mobile' => $request->customer_mobile,
                'customer_email' => $request->customer_email,
                'payment_method' => $request->payment_method_id
            ]);
//            $order_cookie = $request->cookie('order', 'order' . $carts[0]->id . Str::random(20));
            $order = new Order();
            $order->identifier = rand(1000000000, 9999999999);
            $order->customer_name = $request->customer_first_name . ' ' . $request->customer_second_name;
            $order->customer_mobile = $request->customer_mobile;
            $order->customer_email = $request->customer_email;
            $order->total_quantity = $request->total_quantity;
            $order->payment_method_id = $request->payment_method_id;
            $order->status = OrderStatusEnum::PENDING;
            $order->shipped_status = ShippingEnum::PREPARING;
            $order->shipped_price = $request->shipped_price;

            if ($request->promo_code && $request->promo_code != '') {
                $promo = PromoCode::active()->valid()->where('code' , $request->promo_code)->first();
                if ($promo && $promo->type === 1) {
                    $total = +($total - ($total * $promo->value / 100));
                    $order->promo_code_id = $promo->id;
                }elseif($promo && $promo->type === 0){
                    $total = +($total -   $promo->value  );
                    $order->promo_code_id = $promo->id;
                }
            }

            $order->total = $total;
            $order->cookies = $encodedInputs;
            $order->address = $request->area . ' , ' . $request->st_name . ' , ' . $request->apartment . ' , ' . $request->floor;

            if ($request->hasFile('image')) {
                $order->image = $this->storeImage2($request, Order::staticPath(), $request->image, 'image');
            }

            $order->save();


            $order_cookie = $request->cookie('order', 'order' . $order->id . $carts[0]->id . Str::random(20));
            $order->unique_order_cookies = $order_cookie;
            $order->save();


            OrderExtraDetails::create([
                'order_id' => $order->id,
                'ship_to_me' => $request->ship_to_me,
                'greeting_card' => $request->greeting_card,
                'extra_instructions' => $request->extra_instructions,
                'know_receipent_address' => $request->know_receipent_address,
                'same_day' => $request->same_day,
                'delivery_date' => $request->delivery_date,
                'specific_time_slot_status' => $request->specific_time_slot_status,
                'specific_time' => $request->specific_time,
                'delivery_place' => $request->delivery_place,
                'hide_my_name_status' => $request->hide_my_name_status,
                'st_name' => $request->st_name,
                'shipping_cost' => $request->shipping_cost ?? 0, //here
            ]);

            if ($request->recepient_name && $request->recepient_name) {
                ReceipentsDetails::create([
                    'order_id' => $order->id,
                    'name' => $request->recepient_name,
                    'mobile' => $request->recepient_mobile
                ]);
            }


            if ($request->area) {
                DeliveryDetails::create([
                    'st_name' => $request->st_name,
                    'apartment' => $request->apartment,
                    'floor' => $request->floor,
                    'area' => $request->area,
                    'order_id' => $order->id,
                    'shipping_cost' => $request->shipping_cost ?? 0, //here
                    'total' => $order->total,
                    'payment_method_id' => $request->payment_method_id,
                    'status' => 0,
                ]);
            }


            foreach ($carts as $cart) {
                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product_name,
                    'sale' => 0,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'total' => $cart->total,
                    'price_after_sale' => $cart->price,
                    'refund_status' => 0,

                ]);

                $cart->delete();
            }

            Cookie::forget('cart');

            $order = $order->load('orderDetails');

            $myCookie = $request->cookie('customer_info', $encodedInputs); //the   customer details of order
            $myCookie2 = $request->cookie('order', $order_cookie); //the unique identitfier of order


            ShippingOrderStatus::create([
                'order_id' => $order->id,
                'shipped_status' => ShippingEnum::RECEIVING,
            ]);
            ShippingOrderStatus::create([
                'order_id' => $order->id,
                'shipped_status' => ShippingEnum::PREPARING,
            ]);


            OrderStatus::create([
                'order_id' => $order->id,
                'status' => OrderStatusEnum::PENDING,
            ]);


            $data = ['data' => ['order' => new OrderResource($order), 'type' => 'success', 'cookie_name' => 'customer_info', 'cookie_value' => $myCookie, 'cookie_name2' => 'order', 'cookie_value2' => $myCookie2], 'message' => __('success'), 'code' => 201];
            if ($order && $order->orderDetails && $order->orderDetails->count()) {

                /*****************/
//                event(new OrderEvent($order));    //  event of sending emails
                /****************/

                DB::commit();

                return $this->successWithCookies($data['data'], $data['message'], $data['code']);

            } else {
                return $this->error([], __('message.failed'), 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], __('message.failed') . ' ' . $e->getMessage(), 500);

        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderApiRequest;
use App\Models\Order;
use App\Models\Rate;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use function Symfony\Component\Mime\Header\all;

class RatingController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request)

    {

        $order = Order::where('unique_order_cookies', $request->order_cookie)->where('unique_order_cookies', '<>', null)
            ->first();

        if ($order && $order->is_rated) {
            return $this->error([], __('admin.order_already_rated'), 404);
        }

        if (!$order) {
            return $this->notFoundResponse();
        }


//        if (count($request->rate['id']->product_id) !== count($request->rate)) {
//            return $this->error([], __('admin.product_and_rating_mismatch'), 400);
//        }


        if (!empty($request->rate)) {
            foreach ($request->rate as $key => $val) {
                if (isset($val['id']) && isset($val['rate']) && is_numeric($val['id']) && is_numeric($val['rate']) && $val['rate'] > 0) {
                    Rate::create([
                        "product_id" => $val['id'],
                        "rating_value" => $val['rate'],
                        "order_id" => $order->id,
                    ]);
                }
            }
        }
        $order->is_rated = 1;
        $order->save();
        return $this->success([], __('admin.thank_you_for_your_rating'), 201);
    }


//     public function store(OrderApiRequest $request)
//    public function store(Request   $request)
//
//    {
//
//        $order = Order::where('unique_order_cookies', $request->order_cookie)->where('unique_order_cookies', '<>', null)
//            ->first();
//
//        if ($order && $order->is_rated) {
//            return $this->error([] , __('admin.order_already_rated') , 404);
//        }
//
//        if (!$order) {
//            return $this->notFoundResponse();
//        }
//
//
//        if (count($request->rate['id']->product_id) !== count($request->rate)) {
//            return $this->error([], __('admin.product_and_rating_mismatch'), 400);
//        }
//
//        if (!empty($request->rate)) {
//            foreach ($request->product_id as $key => $val) {
//                Rate::create([
//                    "product_id" => $val,
//                    "rating_value" => $request->rate[$key],
//                    "order_id" => $order->id,
//                ]);
//            }
//        }
//        $order->is_rated = 1;
//        $order->save();
//        return $this->success([], __('admin.thank_you_for_your_rating'), 201);
//    }
}

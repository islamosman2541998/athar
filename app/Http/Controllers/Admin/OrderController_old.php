<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Enums\ShippingEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Mail\OrderMail;
use App\Models\Occasion;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Settings\HomeSettingSingleton;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController_old extends Controller
{
    public function index(Request $request)
    {

        $query = Order::with('orderDetails')->orderBy('id', 'DESC');


        if ($request->identifier) {
            $query = $query->where('identifier', 'like', '%' . request()->input('identifier') . '%');
        }


        if ($request->customer_email) {
            $query = $query->where('customer_email', 'like', '%' . request()->input('customer_email') . '%');
        }

        if ($request->customer_mobile) {
            $query = $query->where('customer_mobile', 'like', '%' . request()->input('customer_mobile') . '%');

        }


        /*************************search of date******************/
        if ($request->from_date && $request->to_date) {
            $from = date($request->from_date);
            $to = date($request->to_date);
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }
        if ($request->from_date != '' && $request->to_date == '') {
            $from = date($request->from_date);
            $to = now();
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }

        if ($request->to_date != '' && $request->from_date == '') {
            $from = date("1-1-2000");
            $to = date($request->to_date);
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }

        /*************************search of date******************/
        $items = $query->paginate($this->pagination_count);
        return view('admin/dashboard/orders/index', compact('items'));
    }


    public function show($id)
    {
        $orders = Order::find($id);
        return view('admin.dashboard.orders.show', compact('orders'));
    }


    public function edit($id)
    {
        $orders = Order::with('orderStatus')->find($id);
        $all_statuses = array_values(OrderStatusEnum::values());
        $orderStatuses = OrderStatus::where('order_id', $orders->id)->latest()->pluck('status')->skip(1)->toArray();
        $myStatuses = array_diff($all_statuses, array_intersect($orderStatuses, $all_statuses));

        return view('admin.dashboard.orders.edit', compact('orders', 'myStatuses'));

    }

    public function update($id, OrderRequest $request)
    {
        $request->validated();
        $order = Order::find($id);

        $order->update([
            'shipped_status' => $request->shipped_status,
            'shipped_price' => $request->shipped_price,
            'updated_by' => auth()->id(),
            'refund_status' => $request->refund_status,
        ]);



        if($request->status != null  && ($request->status !== $order->status || $order->orderStatus()->count() == 0 )) {
            $order->update([ 'status' => $request->status]);

            OrderStatus::create([
                'order_id' => $order->id,
                'status' => $request->status,
                'description' => $request->description,
            ]);
        }


        foreach ($request->detail_id as $key => $val) {
            $orderDetal = OrderDetail::find($val);
            if ($orderDetal) {
                $orderDetal->refund_status = $request->refund_status[$key];
                $orderDetal->save();
            }
        }


        session()->flash('success', __('messages.admin.success'));
        return redirect()->back();
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            session()->flash('error', 'admin.messages.not_found');
            return redirect()->back();
        }
        $ids = $order->orderDetails()->pluck('id');

        OrderDetail::whereIn('id', $ids)->delete();
        $order->delete();
        session()->flash('success', 'admin.messages.deleted_successfully');
        return redirect()->back();

    }


    public function actions(Request $request)
    {

        if ($request['delete_all'] == 1) {
            $products = Order::findMany($request['record']);
            foreach ($products as $product) {
                $this->destroy($product->id);
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


    public function sendOrderConfirmation($orderId)
    {
        // Assuming you retrieve the order from the database
        $order = Order::find($orderId);
        Mail::to($order->customer_email)->send(new OrderMail($order));

        return 'Order confirmation email sent!';
    }


    public function deleteOrderStatus($orderId , $orderStatusId)
    {
         // Assuming you retrieve the order from the database
        $order = Order::find($orderId)->status;
        $orderStatus = OrderStatus::find($orderStatusId);
        if($order == $orderStatus->status){
            session()->flash('error', 'admin.messages.change_status_of_order_first_to_can_delete_this');
            return redirect()->back();
        }

        $orderStatus->delete();
        session()->flash('success', 'admin.messages.status_deleted_successfully');
        return redirect()->back();

    }

}

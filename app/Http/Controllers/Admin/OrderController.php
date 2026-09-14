<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Enums\ShippingEnum;
use App\Events\UpdateShippingStatusEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Mail\OrderMail;
use App\Models\Occasion;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ShippingOrderStatus;
use App\Settings\HomeSettingSingleton;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class OrderController extends Controller
{


    public function index(Request $request)
    {


        if ($request->input('export') === 'excel') {
        return Excel::download(new OrdersExport($request), 'orders.xlsx');
    }

        $query = Order::with('orderDetails', 'updatedBy:id,name')->orderBy('id', 'DESC');


        if ($request->identifier) {
            $query = $query->where('identifier', 'like', '%' . request()->input('identifier') . '%');
        }


        if ($request->customer_email) {
            $query = $query->where('customer_email', 'like', '%' . request()->input('customer_email') . '%');
        }

        if ($request->customer_mobile) {
            $query = $query->where('customer_mobile', 'like', '%' . request()->input('customer_mobile') . '%');
        }


        if ($request->filled('status')) {
        $statuses = (array) $request->input('status');       
        $query->whereIn('status', $statuses);
    }


        if ($request->filled('shipped_status')) {
    $statuses = (array) $request->input('shipped_status');
    $query->whereIn('shipped_status', $statuses);
}

        /*************************search of price******************/
        if ($request->from_total != '') {
            $query = $query->where('total', '>=', $request->from_total);
        }

        if ($request->to_total != '') {
            $query = $query->where('total', '<=', $request->to_total);
        }
        /*************************search of price******************/


        /*************************search of date******************/
        if ($request->from_date && $request->to_date) {
            $from = date($request->from_date);
            $to = date($request->to_date);
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }

        if ($request->from_date != '' && $request->to_date == '') {
            $from = date($request->from_date);
            $query->whereDate('created_at', '>', Carbon::parse($from));
        }


        if ($request->to_date != '' && $request->from_date == '') {
            $to = date($request->to_date);
            $query->whereDate('created_at', '<', Carbon::parse($to));
        }

        /*************************search of date******************/


        $data['sum'] = (clone $query)->sum('total');

        $data['count'] = (clone $query)->count();
        $data['pending_sum'] = (clone $query)->where('status', OrderStatusEnum::PENDING)->sum('total');
        $data['pending_count'] = (clone $query)->where('status', OrderStatusEnum::PENDING)->count();

        $data['processing_sum'] = (clone $query)->where('status', OrderStatusEnum::PROCESSING)->sum('total');
        $data['processing_count'] = (clone $query)->where('status', OrderStatusEnum::PROCESSING)->count();

        $data['completed_sum'] = (clone $query)->where('status', OrderStatusEnum::COMPLETED)->sum('total');
        $data['completed_count'] = (clone $query)->where('status', OrderStatusEnum::COMPLETED)->count();


        $data['cancelled_sum'] = (clone $query)->where('status', OrderStatusEnum::CANCELLED)->sum('total');
        $data['cancelled_count'] = (clone $query)->where('status', OrderStatusEnum::CANCELLED)->count();

        $data['refunded_sum'] = (clone $query)->where('status', OrderStatusEnum::REFUNDED)->sum('total');
        $data['refunded_count'] = (clone $query)->where('status', OrderStatusEnum::REFUNDED)->count();


        $items = $query->paginate($this->pagination_count);

        return view('admin/dashboard/orders/index', compact('items', 'data'));
    }


    public function show($id)
    {


        $orders = Order::with('orderStatus', 'shippingOrderStatus',  'extraOrderDetails', 'receipentsDetails', 'deliveryDetails', 'promoCode','orderDetails.product')->find($id);


        return view('admin.dashboard.orders.show', compact('orders'));
    }


    public function edit($id)
    {
        $orders = Order::with('orderStatus', 'shippingOrderStatus', 'extraOrderDetails', 'receipentsDetails', 'deliveryDetails', 'promoCode')->find($id);

        $all_statuses = array_values(ShippingEnum::values());
        $orderStatuses = ShippingOrderStatus::where('order_id', $orders->id)->latest()->pluck('shipped_status')->skip(1)->toArray();
        $myStatuses = array_diff($all_statuses, array_intersect($orderStatuses, $all_statuses));


        $order_all_statuses = array_values(OrderStatusEnum::values());
        $order_orderStatuses = OrderStatus::where('order_id', $orders->id)->latest()->pluck('status')->skip(1)->toArray();
        $order_myStatuses = array_diff($order_all_statuses, array_intersect($order_orderStatuses, $order_all_statuses));

        return view('admin.dashboard.orders.edit', compact('orders', 'myStatuses', 'order_myStatuses'));
    }


    public function update($id, OrderRequest $request)
    {
        $request->validated();
        $order = Order::find($id);

        $order->update([
            'shipped_price' => $request->shipped_price,
            'updated_by' => auth()->id(),
            'refund_status' => $request->refund_status,
        ]);


        if ($request->shipped_status != null && ($request->shipped_status !== $order->shipped_status || $order->shippingOrderStatus()->count() == 0)) {
            $order->update(['shipped_status' => $request->shipped_status]);

            ShippingOrderStatus::create([
                'order_id' => $order->id,
                'shipped_status' => $request->shipped_status,
                'description' => $request->description,
            ]);
        }

        if ($request->status != null && ($request->status !== $order->status || $order->orderStatus()->count() == 0)) {
            $order->update(['status' => $request->status]);

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

        /*****************/
        //       event(new UpdateShippingStatusEvent($order));    //event of sending emails
        /****************/


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
            session()->flash('success', trans('admin.messages.delete_all_sucessfully'));
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


    public function deleteOrderStatus($orderId, $orderStatusId)
    {
        // Assuming you retrieve the order from the database
        $order = Order::find($orderId)->status;
        $orderStatus = OrderStatus::find($orderStatusId);
        if ($order == $orderStatus->status) {
            session()->flash('error', 'admin.messages.you_cannot_delete_current_status_change_status_of_order_first_to_can_delete_this');
            return redirect()->back();
        }

        $orderStatus->delete();
        session()->flash('success', 'admin.messages.status_deleted_successfully');
        return redirect()->back();
    }


    public function deleteShippingOrderStatus($orderId, $shipping_order_status_id)
    {
        // Assuming you retrieve the order from the database
        $order = Order::find($orderId)->shipped_status;
        $orderStatus = ShippingOrderStatus::find($shipping_order_status_id);
        if ($order == $orderStatus->shipped_status) {
            session()->flash('error', 'admin.messages.you_cannot_delete_current_status_change_status_of_order_first_to_can_delete_this');
            return redirect()->back();
        }

        $orderStatus->delete();
        session()->flash('success', 'admin.messages.shipping_status_deleted_successfully');
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Enums\ShippingEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        $data['orders']['orders_count'] = Order::count();
        $data['orders']['orders_total_of_sum'] = Order::sum('total');
        $data['orders']['pending_orders_count'] = Order::where('status', OrderStatusEnum::PENDING)->count();
        $data['orders']['pending_orders_total_of_sum'] = Order::where('status', OrderStatusEnum::PENDING)->sum('total');
        $data['orders']['delivered_orders_count'] = Order::where('shipped_status', ShippingEnum::DELIVERED)->count();
        $data['orders']['delivered_orders_total_of_sum'] = Order::where('shipped_status', ShippingEnum::DELIVERED)->sum('total');

        return view('admin.dashboard.index', compact('data'));
    }
}

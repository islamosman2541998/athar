<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Occasion;
use App\Models\Order;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsReportsController extends Controller
{
    public function reports(Request $request)
    {
        $query = DB::table('orders');

        if ($request->customer_name != '') {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }
        if ($request->customer_mobile != '') {
            $query->where('customer_mobile', 'like', '%' . $request->customer_mobile . '%');
        }
        if ($request->customer_email != '') {
            $query->where('customer_email', 'like', '%' . $request->customer_email . '%');
        }

        if ($request->from_date && $request->to_date) {
            $from = Carbon::parse($request->from_date)->startOfDay();
            $to = Carbon::parse($request->to_date)->endOfDay();
            $query->whereBetween('created_at', [$from, $to]);
        } elseif ($request->from_date) {
            $from = Carbon::parse($request->from_date)->startOfDay();
            $query->where('created_at', '>=', $from);
        } elseif ($request->to_date) {
            $to = Carbon::parse($request->to_date)->endOfDay();
            $query->where('created_at', '<=', $to);
        }

        $items = $query
            ->select(
                'customer_mobile',
                DB::raw('MAX(customer_name) as customer_name'),
                DB::raw('MAX(customer_email) as customer_email'),
                DB::raw('COUNT(id) as total_orders'),
                DB::raw('SUM(total) as all_total'),
                DB::raw('MAX(created_at) as created_at')
            )
            ->groupBy('customer_mobile')
            ->latest('created_at')
            ->get();

        $from = $request->from_date ? Carbon::parse($request->from_date)->startOfDay() : Carbon::now()->subMonth();
        $to = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : Carbon::now();

        $newCustomersQuery = DB::table('orders')
            ->select(DB::raw('COUNT(DISTINCT customer_mobile) as new_customers'))
            ->whereBetween('created_at', [$from, $to]);
        $newCustomers = $newCustomersQuery->first()->new_customers;

        $totalOrdersQuery = DB::table('orders')
            ->select(DB::raw('COUNT(id) as total_orders'))
            ->whereBetween('created_at', [$from, $to]);
        $totalOrders = $totalOrdersQuery->first()->total_orders;

        return view('admin.dashboard.reports.clients.index', [
            'items' => $items,
            'newCustomers' => $newCustomers,
            'totalOrders' => $totalOrders
        ]);
    }
}

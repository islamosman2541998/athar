<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromQuery, WithMapping, WithHeadings
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $req = $this->request;
        $query = Order::query()->orderBy('id','desc');

        if ($req->identifier) {
            $query->where('identifier','like',"%{$req->identifier}%");
        }
        if ($req->customer_email) {
            $query->where('customer_email','like',"%{$req->customer_email}%");
        }
        if ($req->filled('status')) {
            $query->whereIn('status', (array)$req->status);
        }
        // …

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Identifier',
            'Customer Name',
            'Customer Email',
            'Customer Mobile',
            'Total Quantity',
            'Total',
            'Status',
            'Shipped Status',
            'Created At',
            'Updated At',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->identifier,
            $order->customer_name,
            $order->customer_email,
            $order->customer_mobile,
            $order->total_quantity,
            $order->total,
            $order->status,
            $order->shipped_status,
            $order->created_at->toDateTimeString(),
            $order->updated_at->toDateTimeString(),
        ];
    }
}

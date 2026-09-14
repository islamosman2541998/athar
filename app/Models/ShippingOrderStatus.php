<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingOrderStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'shipped_status',
        'description',
        'created_by',
        'updated_by',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class , 'order_id');
    }
}

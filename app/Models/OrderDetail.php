<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';

    // Specify the fillable attributes
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'sale',
        'price_after_sale',
        'quantity',
        'total',
        'refund_status',
        'created_by',
        'updated_by',
        'user_input',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

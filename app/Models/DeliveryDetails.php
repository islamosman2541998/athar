<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'st_name',
        'apartment',
        'floor',
        'area',
        'order_id',
        'shipping_cost',
        'total',
        'payment_method_id',
        'status',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    /***********scopes***********
     * @param $query
     * @return
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}

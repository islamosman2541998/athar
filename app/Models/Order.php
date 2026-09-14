<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Enums\ShippingEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'customer_name',
        'customer_mobile',
        'customer_email',
        'total_quantity',
        'payment_method_id',
        'status',
        'shipped_status',
        'shipped_price',
        'promo_code_id',
        'discount',
        'total',
        'cookies',
        'unique_order_cookies',
        'address',
        'created_by',
        'updated_by',
        'is_rated',
        'image',
    ];



    // Optionally define the relationships (example)
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }


    public function orderStatus()
    {
        return $this->hasMany(OrderStatus::class, 'order_id');
    }

    public function shippingOrderStatus()
    {
        return $this->hasMany(ShippingOrderStatus::class, 'order_id');
    }


    public function receipentsDetails()
    {
        return $this->hasOne(ReceipentsDetails::class, 'order_id');
    }

    public function deliveryDetails()
    {
        return $this->hasOne(DeliveryDetails::class, 'order_id');
    }



    public function extraOrderDetails()
    {
        return $this->hasOne(OrderExtraDetails::class, 'order_id');
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }

    /*******************scopes **************/

    public function scopeDelivered($query)
    {
        //        return $query->where('status', OrderStatusEnum::DELIVERED);
        return $query->where('shipped_status', ShippingEnum::DELIVERED);
    }

    public function scopePending($query)
    {
        //        return $query->where('status', OrderStatusEnum::DELIVERED);
        return $query->where('status', OrderStatusEnum::PENDING);
    }





    public function scopeNotrated($query)
    {
        return $query->where('is_rated', 0);
    }


    public function scopeRated($query)
    {
        return $query->where('is_rated', 1);
    }








    /*******************images part ********************/

   public static function staticPath()
{
    return '/storage/orders/';
}

public function path()
{
    return '/storage/orders/';
}

public function pathInView()
{
    if ($this->image && file_exists(public_path($this->path() . $this->image))) {
        return $this->path() . $this->image; 
    }

    return '/attachments/no_image/no_image.png';
}
}

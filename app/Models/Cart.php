<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_name',
        'cookeries',
        'pocket_id',
        'price',
        'total_price',
        'quantity',
        'total',
        'cart_group_id',
        'user_input',
        'original_input',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pocket()
    {
        return $this->belongsTo(ProductPocket::class, 'pocket_id');
    }


    public function group()
    {
        return $this->belongsTo(CartGroup::class, 'cart_group_id');
    }

    public function scopeByCookeries($query, $cookeries)
    {
        return $query->where('cookeries', $cookeries);
    }
}

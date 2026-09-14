<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderExtraDetails extends Model
{
    use HasFactory;

    protected $table = 'order_extra_details';

    protected $fillable = [
        'order_id',
        'ship_to_me',
        'greeting_card',
        'extra_instructions',
        'know_receipent_address',
        'same_day',
        'delivery_date',
        'specific_time_slot_status',
        'specific_time',
        'delivery_place',
        'hide_my_name_status',
        'st_name',
        'shipping_cost',
        'status',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'order_id' => 'integer',
        'ship_to_me' => 'boolean',
        'know_receipent_address' => 'boolean',
        'same_day' => 'boolean',
        'specific_time_slot_status' => 'boolean',
        'delivery_place' => 'boolean',
        'hide_my_name_status' => 'boolean',
        'shipping_cost' => 'float',
        'status' => 'integer',
        'delivery_date' => 'datetime',
        // 'specific_time' => 'datetime:H:i:s',

    ];




    public function order()
    {
        return $this->belongsTo(Order::class , 'order_id');
    }

}

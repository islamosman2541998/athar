<?php

namespace App\Enums;

class ShippingEnum
{
    public const RECEIVING = 'reciveing';
    public const PREPARING = 'preparing';
    public const DELIVERING = 'delivering';
    public const DELIVERED = 'delivered';
    public const CANCELLED = 'cancelled';
    public const REFUNDED = 'refunded';


//    public const colors = [
//        'reciveing' => ' #ccf2ff',
//        'preparing' => '#8080ff',
//        'delivering' => '#ffff80',
//        'delivered' => '#80ff80',
//        'cancelled' => '#ff8080',
//        'refunded' => '#ff9f80',
//    ];
    public const colors = [
        'reciveing' => 'lightblue',
        'preparing' => 'violet',
        'delivering' => 'blue',
        'delivered' => 'green',
        'cancelled' => 'red',
        'refunded' => 'orange',
    ];



    public static function values(): array
    {

        return [
            static::RECEIVING => 'reciveing',
            static::PREPARING => 'preparing',
            static::DELIVERING => 'delivering',
            static::DELIVERED => 'delivered',
            static::CANCELLED => 'cancelled',
            static::REFUNDED => 'refunded',

        ];

    }



//
//    public const PENDING = 'pending';
//    public const PICKING = 'picking';
//    public const PICKED = 'picked';
//    public const DELIVERING ='delivering';
//    public const DELIVERED = 'delivered';
//    public const CANCELED = 'canceled';
//
//    public const colors  =[
//        'pending' => 'lightblue',
//        'picking' => 'gray',
//        'picked' => 'blue',
//        'delivering' => 'orange',
//        'delivered' => 'green',
//        'canceled' => 'red',
//    ];
//
//
//    public static function values(): array
//    {
//
//        return [
//            static::PENDING => 'pending',
//            static::PICKING => 'picking',
//            static::PICKED => 'picked',
//            static::DELIVERING =>'delivering',
//            static::DELIVERED =>'delivered',
//            static::CANCELED => 'canceled'
//
//        ];
//
//    }


}

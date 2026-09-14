<?php

namespace App\Enums;

class OrderStatusEnum
{


    public const PENDING = 'pending';
    public const PROCESSING = 'processing';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';
    public const REFUNDED = 'refunded';

    //        'reciveing' => ' # ',
//        'preparing' => '#',
//        'delivering' => '#',
//        'delivered' => '#',
//        'cancelled' => '#',
//        'refunded' => '#',


    public const colors = [
        'pending' => '#ccf2ff',
        'processing' => '#8080ff',
        'completed' => '#80ff80',
        'cancelled' => '#ff8080',
        'refunded' => '#ff9f80',
    ];


    public static function values(): array
    {

        return [
            static::PENDING => 'pending',
            static::PROCESSING => 'processing',
            static::COMPLETED => 'completed',
            static::CANCELLED => 'cancelled',
            static::REFUNDED => 'refunded',

        ];

    }



// (Done automatic)
// (Done automatic)
// جاري  التسليم
// تم التسليم

//
//    public const RECEIVING = 'reciveing';
//    public const PREPARING = 'preparing';
//    public const DELIVERING = 'delivering';
//    public const DELIVERED = 'delivered';
//    public const CANCELLED = 'cancelled';
//    public const REFUNDED = 'refunded';
//
//
//    public const colors = [
//        'reciveing' => ' #ccf2ff',
//        'preparing' => '#8080ff',
//        'delivering' => '#ffff80',
//        'delivered' => '#80ff80',
//        'cancelled' => '#ff8080',
//        'refunded' => '#ff9f80',
//    ];
//
//
//    public static function values(): array
//    {
//
//        return [
//            static::RECEIVING => 'reciveing',
//            static::PREPARING => 'preparing',
//            static::DELIVERING => 'delivering',
//            static::DELIVERED => 'delivered',
//            static::CANCELLED => 'cancelled',
//            static::REFUNDED => 'refunded',
//
//        ];
//
//    }
//

}

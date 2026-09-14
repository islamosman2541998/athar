<?php

namespace App\Enums;


use Spatie\Enum\Laravel\Enum;
 
class MunesEnums  
{


    public const DYNAMIC = 'dynamic';
    public const STATIC = 'static';


    public static function values() : array{

        return [

            static::STATIC => 'static',

            static::DYNAMIC => 'dynamic',

        ];

    }


}

<?php

namespace App\Enums;
 
class MenuPositionEnums  
{


    public const MAIN = 'main';
    // public const SIDE = 'side';
    public const FOOTER = 'footer';


    public static function values() : array{

        return [
            static::MAIN => 'main',
            // static::SIDE => 'side',
            static::FOOTER => 'footer',
        ];

    }


}

<?php

namespace App\Enums;
 
class KafaraEnums  
{


    public const WEB = 'web';
    public const APP = 'app';
    public const BOTH = 'both';


    public static function values() : array{

        return [
            static::WEB => 'web',
            static::APP => 'app',
            static::BOTH => 'both',
        ];

    }


}

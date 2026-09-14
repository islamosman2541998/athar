<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeTranslation extends Model
{
    use HasFactory;
    protected $table = 'promo_codes_translations';
    protected $fillable = [
        'promo_code_id',
        'locale',
        'title',
    ];


}

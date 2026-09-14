<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTipsTranslation extends Model
{
    use HasFactory;

    protected $table = 'product_tips_translations';

    protected $fillable = [
        'product_tips_id',
        'locale',
        'title',
        'description',
    ];
}

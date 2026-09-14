<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInfoTranslation extends Model
{
    use HasFactory;

    protected $table = 'product_info_translations';

    protected $fillable = [
        'product_info_id',
        'locale',
        'title',
        'description',
    ];
}

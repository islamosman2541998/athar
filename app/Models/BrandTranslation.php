<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrandTranslation extends Model
{
    use HasFactory;
    protected $table = 'brand_translations';
    protected $fillable = [
        'brand_id',
        'title',
        'locale',
    ];
}

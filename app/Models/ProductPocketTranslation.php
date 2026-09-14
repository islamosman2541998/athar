<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPocketTranslation extends Model
{
    protected $fillable = ['pocket_name', 'locale'];

    public $timestamps = true;
}
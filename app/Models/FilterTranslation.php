<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'filter_translations';

    protected $fillable = [
        'filter_id ',
        'locale',
        'name',
        'slug',
    ];
}

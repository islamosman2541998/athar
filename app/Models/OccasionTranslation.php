<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccasionTranslation extends Model
{
    use HasFactory;
    protected $table = 'occassions_translations';
    protected $fillable = [
        'occassion_id',
        'locale',
        'title',
        'description',

//        'slug',
//        'meta_title',
//        'meta_desc',
//        'meta_key',
    ];


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewTranslation extends Model
{
    protected $table = 'reviews_translations';
    use HasFactory;
    protected $fillable = [
        'review_id',
        'locale',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',


    ];
}

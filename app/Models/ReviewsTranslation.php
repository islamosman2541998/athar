<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewsTranslation extends Model
{
    use HasFactory;
    protected $table = 'reviews_translations';

    protected $fillable = [
        'review_id',
        'title',
        'slug',
        'type',
        'description',
        'locale',
    ];
}

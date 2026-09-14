<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerCategoryTranslation extends Model
{
    use HasFactory;
    protected $table = 'career_category_translations';
    protected $fillable = [
        'career_category_id',
        'title',
        'slug',
        'locale',
     ];

     
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategoryFollowingTranslation extends Model
{
    use HasFactory;

    protected $table = 'service_category_following_translations';
    protected $fillable = ['service_category_following_id', 'locale', 'title', 'description'];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProjectsTranslation extends Model
{
    use HasFactory;
    protected $table = 'category_projects_translations';
    
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'meta_description',
        'meta_title',
        'meta_key',
        'locale',
     ];
}

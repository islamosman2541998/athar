<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryProjects extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'level',
        'sort',
        'feature',
        'status',
        'kafara',
        'image',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'category_id';

    public $translatedAttributes = [
        'category_id',
        'locale',
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_key',
    ];


    public function ads(){
        return $this->hasMany(Ads::class, 'model_id', 'id')->where('model', 'App\Models\Categories');
    }

}

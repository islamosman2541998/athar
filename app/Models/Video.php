<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    public $translatedAttributes = ['title', 'slug', 'description', 'video_id',
        'locale', 'meta_title', 'meta_description', 'meta_key'];

    protected $fillable = [
        'video_id',
        'image',
        'url',
        'sort',
        'feature',
        'status',
        'created_by',
        'updated_by',
    ];


    protected $translationForeignKey = 'video_id';


    public function trans()
    {
        return $this->hasMany(VideoTranslation::class, 'video_id', 'id');
    }


   

    // Scopes ---------------------------------------------------------------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }
}

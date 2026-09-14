<?php

namespace App\Models;

use App\Models\Job;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CareerCategory extends Model
{
    use HasFactory, Translatable, SoftDeletes;
    
    public $translatedAttributes = [
        'title',
        'slug',
        'locale',
        'career_category_id'
    ];
    
    protected $translationForeignKey = 'career_category_id';
    
    protected $fillable = [
        'sort',
        'feature',
        'status',
        'created_by',
        'updated_by',
    ];

    // relations ------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(CareerCategoryTranslation::class, 'career_category_id');
    }

    public function transNow()
    {
        return $this->hasOne(CareerCategoryTranslation::class, 'career_category_id')
                    ->where('locale', app()->getLocale());
    }

    public function job()
    {
        return $this->hasMany(Job::class, 'career_category_id', 'id');
    }

    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }
}
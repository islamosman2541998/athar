<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use Translatable, SoftDeletes;

    public $translatedAttributes = [
        'slug',
        'title',
        'short_description',
        'description',
        'job_desc',
        'requirements',
        'seo_title',
        'seo_description',
        'meta_key',
        'meta_desc',
        'meta_title'

    ];

    protected $fillable = [

        'career_category_id',
        'employment_type',
        'location',
        'image',
        'status',
        'feature',
        'sort',
        'created_by',
        'updated_by'
    ];

    public function cvs()
    {
        return $this->hasMany(Cv::class);
    }

  public function career_category()
    {
        return $this->belongsTo(CareerCategory::class, 'career_category_id')->with('trans');
    }
    public function trans()
    {
        return $this->hasMany(JobTranslation::class, 'job_id');
    }

    public function transNow()
    {
        return $this->hasOne(JobTranslation::class, 'job_id')->where('locale', app()->getLocale());
    }

    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}

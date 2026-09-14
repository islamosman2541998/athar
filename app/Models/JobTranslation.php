<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTranslation extends Model
{
    protected $table = 'job_translations';

    public $timestamps = false;
    protected $fillable = [
        'job_id',
        'locale',
        'title',
        'short_description',
        'description',
        'job_desc',
        'requirements',
        'seo_title',
        'seo_description',
        'slug',
        'meta_key',
        'meta_desc',
        'meta_title'
    ];
}

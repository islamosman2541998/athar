<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'blog_translations';
    protected $fillable = 
    ['blog_id', 
    'title',
    'description',
    'locale',
    'slug',
    'meta_key',
    'meta_desc',
    'meta_title'
];

public function blog()
    {
        return $this->belongsTo(Blog::class , 'blog_id');
    }
}

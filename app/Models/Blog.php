<?php
// app/Models/Blog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes =
    [
        'blog_id',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'locale',


    ];



    protected $fillable = 
    ['image',
    'status',
    'feature',
    'sort',
];

    protected $translationForeignKey = 'blog_id';


    public function trans()
    {
        return $this->hasMany(BlogTranslation::class, 'blog_id');
    }

    public function transNow()
    {
        return $this->hasOne(BlogTranslation::class, 'blog_id')->where('locale', app()->getLocale());
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


    public function getTransNowAttribute()
    {
        return $this->translations()->where('locale', app()->getLocale())->first();
    }

    public static function staticPath(): string
    {
        return 'attachments/blogs/';
    }

    /**
     */
    public static function diskPath(): string
    {
        return public_path(self::staticPath());
    }

    /**
     */
   public function pathInView(): string
{
    if ($this->image && file_exists(public_path(ltrim($this->image, '/')))) {
        return ltrim($this->image, '/');
    }
    if ($this->image && file_exists(self::diskPath() . $this->image)) {
        $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $this->image);
        if ($webp !== $this->image && file_exists(self::diskPath() . $webp)) {
            return self::staticPath() . $webp;
        }
        return self::staticPath() . $this->image;
    }
    return 'attachments/no_image/no_image.png';
}
}

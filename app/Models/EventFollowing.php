<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class EventFollowing extends Model
{
    use Translatable;

    protected $table = 'event_followings';
    protected $fillable = ['event_id', 'image'];
    public $translatedAttributes = ['title', 'description'];

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'event_id');
    }

    public function translate($locale)
{
    return $this->translations()->where('locale', $locale)->first();
}

    public function path()
    {
        return '/attachments/service_category/event_followings/';
    }

    public function pathInView()
    {
        $fullPath = $this->path() . $this->image;
        return file_exists(public_path($fullPath)) ? $fullPath : '/attachments/no_image/no_image.png';
    }
}
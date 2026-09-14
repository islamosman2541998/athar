<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceCategoryFollowing extends Model
{
    use Translatable, HasFactory;

    protected $table = 'service_category_followings';
    protected $fillable = ['service_category_id', 'image'];

    public $translatedAttributes = ['title', 'description'];

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function path()
    {
        return '/attachments/service_category/followings/';
    }

    public function pathInView()
{
    if (! $this->image) {
        return '/attachments/no_image/no_image.png';
    }

    if (Str::startsWith($this->image, '/attachments')) {
        if (file_exists(public_path($this->image))) {
            return $this->image;
        }
    } else {
        $fullPath = $this->path() . $this->image;
        if (file_exists(public_path($fullPath))) {
            return $fullPath;
        }
    }

    return '/attachments/no_image/no_image.png';
}
}

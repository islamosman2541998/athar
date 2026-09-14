<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory, Translatable; 

    protected $table = 'gallery_images';
    protected $fillable = [
        'id', 'image', 'sort','type', 'gallery_group_id', 'feature', 'status', 'created_by', 'updated_by'
    ];

    public $translatedAttributes = ['title', 'description', 'slug']; 

    public function trans()
    {
        return $this->hasMany(GalleryTranslation::class, 'gallery_id', 'id');
    }

    public function gallery_group()
    {
        return $this->belongsTo(GalleryGroup::class, 'gallery_group_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }

    public function path($type)
    {
        $path = "/attachments/gallery/" . $type . "/";
        return $path;
    }

    public function pathInView($type)
    {
        if (file_exists(public_path() . $this->path($type) . $this->image) && $this->image) {
            $path = $this->path($type) . $this->image;
        } else {
            $path = '/attachments/no_image/no_image.png';
        }
        return $path;
    }
}

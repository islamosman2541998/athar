<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Occasion extends Model
{
    use HasFactory, SoftDeletes;
// , Translatable
    protected $table = 'occassions'; 

    protected $fillable = [
        'type',
        'status',
        'featured',
        'sort',
        'image',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'occassion_id';
    public $translatedAttributes = [
        'occassion_id',
        'locale',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
    ];

    // Relations
    public function transNow()
    {
        return $this->hasOne(OccasionTranslation::class, 'occassion_id', 'id')->where('locale', app()->getLocale());
    }

    public function trans()
    {
        return $this->hasMany(OccasionTranslation::class, 'occassion_id', 'id');
    }

    public function translations()
    {
        return $this->hasMany(OccasionTranslation::class, 'occassion_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_occassions', 'occassion_id', 'product_id');
    }

    public function galleryGroup()
    {
        return $this->hasMany(GalleryGroup::class, 'foreign_key')->where('type', 3);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeature($query)
    {
        return $query->where('featured', 1);
    }
    public function scopeEvent($query)
    {
        return $query->where('type', 1);
    }

    // Boot model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('transNow', function (Builder $builder) {
            $builder->with('transNow');
        });
    }

    public function path()
    {
        $path = "/attachments/occasions/main_images/";
        return $path;
    }

    public function pathInView()
    {
        if (file_exists(public_path() . $this->path() . $this->image) && $this->image) {
            $path = $this->path() . $this->image;
        } else {
            $path = '/attachments/no_image/no_image.png';
        }
        return $path;
    }
}
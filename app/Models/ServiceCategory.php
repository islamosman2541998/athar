<?php

namespace App\Models;

use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
{
    use Translatable, HasFactory;

    protected $table = "service_categories";
    protected $fillable = [
        'image',
        'sort',
        'feature',
        'status',
        'page_id',
        'gallery_id',
        'service_unique_name',
        'created_by',
        'updated_by',
        'info_image',
    ];

    protected $translationForeignKey = 'service_cat_id';
    public $translatedAttributes = [
        'service_cat_id',
        'description',
        'locale',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'info_title',
        'info_description',
    ];

    public function translations()
    {
        return $this->hasMany(ServiceCategoryTranslation::class, 'service_cat_id', 'id');
    }

    public function trans()
    {
        return $this->hasMany(ServiceCategoryTranslation::class, 'service_cat_id', 'id');
    }

    public function getFollowings()
    {
        return $this->hasMany(EventFollowing::class, 'event_id');
    }
    public function transNow()
    {
        return $this->hasOne(ServiceCategoryTranslation::class, 'service_cat_id')->where('locale', app()->getLocale());
    }
   public function serviceRequest()
    {
        return $this->hasMany(ServiceRequest::class);
    }
    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }
    public function services()
    {
        return $this->hasMany(Services::class, 'service_category_id', 'id');
    }


    public function occasions()
    {
        return $this->belongsToMany(Occasion::class, 'service_category_occasions', 'category_service_id', 'occassion_id')
            ->where('type', 1)->orderBy('sort', 'ASC');
    }

    public function followings()
    {
        return $this->hasMany(ServiceCategoryFollowing::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    public function galleryGroup()
    {
        return $this->hasOne(GalleryGroup::class, 'foreign_key', 'id');
        // return $this->hasOne(GalleryGroup::class, 'foreign_key')->where('type', 3);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('transNow', function (Builder $builder) {
            $builder->with('transNow');
        });
    }

    /*******************images part ********************/

    public function path()
    {
        $path = "/attachments/service_category/main_images/";
        return $path;
    }

    static public function staticPath()
    {
        $path = "/attachments/service_category/main_images/";
        return $path;
    }
    public function infoImagePath()
    {
        return '/attachments/service_category/info_images/';
    }
    public function infoImageInView()
    {
        if (file_exists(public_path() . $this->infoImagePath() . $this->info_image) && $this->info_image) {
            return $this->infoImagePath() . $this->info_image;
        } else {
            return '/attachments/no_image/no_image.png';
        }
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

<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryGroup extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'type',
        'status',
        'title',
        'title_en',

        'foreign_key',
        'created_by',


    ];

    protected $translationForeignKey = 'gallery_group_id';
    public $translatedAttributes = [
        'gallery_group_id',
        'locale',
        'title',
        'slug',
        'meta_title',
        'meta_desc',
        'meta_key',
    ];

    public function images()
    {
        return $this->hasMany(Gallery::class, 'gallery_group_id', 'id')->orderBy('sort' , 'ASC');
    }
    

    public function mainImage()
    {
        return $this->hasOne(Gallery::class , 'gallery_group_id')->orderBy( 'sort' , 'asc' );
    }



    public function translations()
    {
        return $this->hasMany(GalleryGroupTranslation::class , 'gallery_group_id');
    }

    public function transNow()
    {
        return $this->hasOne(GalleryGroupTranslation::class , 'gallery_group_id')->where('locale' , app()->getLocale());
    }


    // Scopes ---------------------------------------------------------------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }




    /******************boot model*******************/



    protected static function boot()
    {
        parent::boot();

        // Apply the relationship globally
        static::addGlobalScope('transNow', function (Builder $builder) {
            $builder->with('transNow');
        });
    }

    /******************end boot model**********************/

//'0 -> products ,  1 -> product_categories , 2 -> service_category , 3 ->  occasions '
}

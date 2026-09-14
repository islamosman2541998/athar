<?php

namespace App\Models;

use App\Models\PromoCode;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory, Translatable; 


    protected $fillable = [
        'image',
        //        'sale',
        'sort',
        'feature',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
        'show_in_cart',
        'annual_occasion',
        'show_in_bottom',

    ];
    protected $translationForeignKey = 'product_category_id';
    public $translatedAttributes = [
        'product_category_id',
        'locale',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
    ];


    // relations ---------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(ProductCategoryTranslation::class, 'product_category_id', 'id');
    }
    public function translations()
    {
        return $this->hasMany(ProductCategoryTranslation::class, 'product_category_id', 'id');
    }

    public function transNow()
    {
        return $this->hasOne(ProductCategoryTranslation::class, 'product_category_id', 'id')->where('locale', app()->getLocale());
    }

    public function productCategoriesProducts()
    {
        return $this->belongsToMany(Product::class, 'product_category_products', 'product_category_id', 'product_id');
    }



    //    public function products()
    //    {
    //        return $this->hasMany(Product::class, 'product_category_id', 'id');
    //    }


    //    public function occasions()
    //    {
    //        return $this->belongsToMany(Occasion::class,  'products_occassions' ,'product_id' , 'occassion_id' );
    //    }


    public function createdBy()
    {
        return $this->belongsTo(User::class,  'created_by');
    }

    /**
     * Get the products that belong to this product category.
     *
     * This defines a many-to-many relationship between ProductCategory and Product
     * through the 'product_category_products' pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category_products', 'product_category_id', 'product_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class,  'updated_by');
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
    public function scopeannual_occasion($query)
    {
        return $query->where('annual_occasion', 1);
    }
    public function scopeshow_in_bottom($query)
    {
        return $query->where('show_in_bottom', 1);
    }


public function promoCodes()
{
    return $this->belongsToMany(
        PromoCode::class,
        'promo_code_category',
        'category_id',
        'promo_code_id'
    );
}
    public function scopeFeatured($query)
    {
        return $query->where('status', 1);
    }

    public function scopeShowincart($query)
    {
        return $query->where('show_in_cart', 1);
    }

    public function scopeOrdinary($query)
    {
        return $query->where('show_in_cart', 0);
    }


    public function galleryGroup()
    {
        return $this->hasOne(GalleryGroup::class, 'foreign_key')->where('type', 1);
    }





    /******************boot model*******************/

    protected static function boot()
    {
        parent::boot();

        // // Apply the relationship globally
        // static::addGlobalScope('transNow', function (Builder $builder) {
        //     $builder->with('transNow');
        // });
    }

    /******************end boot model**********************/


    /*******************images part ********************/

    //path of images
    public function path()
    {
        $path = "/attachments/product_category/main_images/";
        return $path;
    }




    //path of images that showed in view
    public function pathInView()
    {
        if (file_exists(public_path() . $this->path() . $this->image)   && $this->image) {
            $path =   $this->path() . $this->image;
        } else {
            $path = '/attachments/no_image/no_image.png';
        }
        return $path;
    }
}

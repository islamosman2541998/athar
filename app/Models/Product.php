<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductCategory;


class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'price',
        'sale',
        'url',
        'price_after_sale',
        'most_selling',
        'best_offer',
        'code',
        'sort',
        'feature',
        'status',
        'created_by',
        'updated_by',
        'product_category_id',
        'in_stock',
        'show_in_cart',
        'deleted_at',
        'has_pockets',
        'show_in_slider',
        'show_text',
        'user_input',
        'product_cart',
    ];

    protected $translationForeignKey = 'product_id';
    public $translatedAttributes = [
        'project_id',
        'locale',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
    ];


    public function trans()
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'id');
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'id');
    }

    public function transNow()
    {
        return $this->hasOne(ProductTranslation::class, 'product_id', 'id')->where('locale', app()->getLocale());
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
    public function categories()
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'product_category_products',
            'product_id',
            'product_category_id'
        );
    }

    public function pockets()
    {
        return $this->hasMany(ProductPocket::class, 'product_id')->with('translations');
    }

    public function paymentLine()
    {
        return $this->hasMany(ProductPaymentLine::class, 'product_id');
    }
    public function tips()
    {
        return $this->hasMany(ProductTips::class, 'product_id');
    }
    public function info()
    {
        return $this->hasMany(ProductInfo::class, 'product_id');
    }


    public function paymentLineActive()
    {
        return $this->hasMany(ProductPaymentLine::class, 'product_id')->active()->orderBy('id', 'ASC');
    }
    public function tipsActive()
    {
        return $this->hasMany(ProductTips::class, 'product_id')->active()->orderBy('id', 'ASC');
    }
    public function infoActive()
    {
        return $this->hasMany(ProductInfo::class, 'product_id')->active()->orderBy('id', 'ASC');
    }

    /**
     * Get the order details associated with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function filters()
    {
        return $this->belongsToMany(Filter::class, 'filter_product');
    }

    public function occasions()
    {
        return $this->belongsToMany(Occasion::class, 'products_occassions', 'product_id', 'occassion_id')
            ->where('type', 0)
            ->orderBy('sort', 'ASC');
    }
    //     public function occasions()
    // {
    //     return $this->belongsToMany(Occasion::class, 'products_occassions', 'product_id', 'occassion_id');
    // }


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
        return $this->hasOne(GalleryGroup::class, 'foreign_key')->where('type', 0);
    }


    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function rates()
    {
        return $this->hasMany(Rate::class, 'product_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }


    public function productCategoriesProducts()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category_products', 'product_id', 'product_category_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeshow_in_slider($query)
    {
        return $query->where('show_in_slider', 1);
    }

    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }

    public function scopeShowincart($query)
    {
        return $query->where('product_cart', 1);
    }

    public function scopeOrdinary($query)
    {
        return $query->where('show_in_cart', 0);
    }

    // Boot
    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('transNow', function (Builder $builder) {
        //     $builder->with('transNow');
        // });
    }

    public function getAverageRatingAttribute()
    {
        return $this->rates->avg('rating_value') ?? 0;
    }

    public static function staticPath()
    {
        return "/attachments/products/";
    }

    public function path()
    {
        return "/attachments/products/";
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

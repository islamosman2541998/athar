<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Filter extends Model
{
    use Translatable;

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'slug',
    ];

    /**
     * The foreign key on the translation table.
     *
     * @var string
     */
    protected $translationForeignKey = 'filter_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    /**
     * Get the children filters.
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the parent filter.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the translation for the current locale.
     */
    public function transNow()
    {
        return $this->hasOne(FilterTranslation::class, 'filter_id', 'id')
                    ->where('locale', app()->getLocale());
    }
    public function trans()
    {
        return $this->hasMany(FilterTranslation::class, 'filter_id', 'id');
    }

    /**
     * Get all translations.
     */
    public function translations()
    {
        return $this->hasMany(FilterTranslation::class, 'filter_id', 'id');
    }

    /**
     * Filters belong to many products.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'filter_product');
    }
}

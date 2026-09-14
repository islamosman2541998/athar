<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'product_category_translations';

    protected $fillable =
        [
            'product_category_id',
            'locale',
            'title',
            'slug',
            'description',
            'meta_title',
            'meta_desc',
            'meta_key',
        ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class,  'product_category_id');
    }

}

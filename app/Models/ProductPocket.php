<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductPocket extends Model
{
    use Translatable;

    public $translatedAttributes = ['pocket_name'];

    protected $fillable = ['product_id', 'price', 'image'];

    public function translations()
    {
        return $this->hasMany(ProductPocketTranslation::class, 'product_pocket_id');
    }
    public function getImagePathAttribute()
    {
        return $this->image
            ? "/attachments/pockets/{$this->image}"
            : "/attachments/no_image.png";
    }
}
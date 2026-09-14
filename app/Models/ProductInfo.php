<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInfo extends Model
{

    use HasFactory, Translatable;
 
    protected $fillable = ['product_id', 'sort', 'status'];
    // transatable table
    public $translatedAttributes = ['product_info_id', 'locale', 'title', 'description'];
    // foreign key
    protected $translationForeignKey = 'product_info_id';

    public function trans(){
        return $this->hasMany(ProductInfoTranslation::class, 'product_info_id');
    }

    public function transNow(){
        return $this->hasOne(ProductInfoTranslation::class, 'product_info_id')->where('locale' , app()->getLocale());
    }

    // Scopes ----------------------------

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeLang($query){
        return $query->trans->where('locale',  app()->getLocale())->first();
    }

}

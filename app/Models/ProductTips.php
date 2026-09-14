<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTips extends Model
{
    use HasFactory, Translatable;
    
    protected $fillable = ['product_id', 'sort', 'status'];
    // transatable table
    public $translatedAttributes = ['product_tips_id', 'locale', 'title', 'description'];
    // foreign key
    protected $translationForeignKey = 'product_tips_id';

    public function trans(){
        return $this->hasMany(ProductTipsTranslation::class, 'product_tips_id');
    }

    public function transNow(){
        return $this->hasOne(ProductTipsTranslation::class, 'product_tips_id')->where('locale' , app()->getLocale());
    }

    // Scopes ----------------------------

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeLang($query){
        return $query->trans->where('locale',  app()->getLocale())->first();
    }
}

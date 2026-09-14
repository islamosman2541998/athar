<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPaymentLine extends Model
{
    use HasFactory, Translatable;
    
    
    protected $fillable = ['product_id',  'links', 'color', 'sort', 'status'];
    // transatable table
    public $translatedAttributes = ['payment_line_id', 'locale', 'title'];
    // foreign key
    protected $translationForeignKey = 'payment_line_id';

    public function trans(){
        return $this->hasMany(ProductPaymentLineTranslation::class, 'payment_line_id');
    }

    public function transNow(){
        return $this->hasOne(ProductPaymentLineTranslation::class, 'payment_line_id')->where('locale' , app()->getLocale());
    }

    // Scopes ----------------------------

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeLang($query){
        return $query->trans->where('locale',  app()->getLocale())->first();
    }

}

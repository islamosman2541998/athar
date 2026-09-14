<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends Model
{

    use Translatable, SoftDeletes;

    public $translatedAttributes = ['title'];
    protected $fillable = ['slug', 'sort', 'status', 'created_by', 'updated_by'];
    protected $translationForeignKey = 'faq_category_id';

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'faq_category_id');
    }

    public function transNow()
    {
        return $this->hasOne(FaqCategoryTranslation::class, 'faq_category_id', 'id')->where('locale', app()->getLocale());
    }


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    
}

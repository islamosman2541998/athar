<?php

namespace App\Models;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoCode extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'code',
        'type',
        'value',
        'start_at',
        'end_at',
        'status',
        'usage_limit',  
        'uses_left',    
    ];

    protected $translationForeignKey = 'promo_code_id';

    public $translatedAttributes = [
        'title',
    ];
// public function categories()
// {
//     return $this->belongsToMany(
//         ProductCategory::class,
//         'promo_code_category', 
//         'promo_code_id',
//         'category_id'
//     );
// }

public function categories()
{
    return $this->belongsToMany(
        ProductCategory::class,
        'promo_code_category', 
        'promo_code_id',
        'category_id'
    );
}
    public function trans()
    {
        return $this->hasMany(PromoCodeTranslation::class, 'promo_code_id');
    }

    public function transNow()
    {
        return $this->hasOne(PromoCodeTranslation::class, 'promo_code_id')
                    ->where('locale', app()->getLocale());
    }

    /****************** scopes ******************/

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeValid($query)
    {
        return $query->where('start_at','<=', now())
                     ->where('end_at','>=', now());
    }
}

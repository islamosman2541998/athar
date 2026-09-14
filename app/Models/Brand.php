<?php

namespace App\Models;

use App\Models\BrandTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use
        HasFactory,
        Translatable;

    protected $fillable = ['status', 'image'];

    public $translatedAttributes = [
        'brand_id',
        'title',
        'locale',
    ];
    // foreign key
    protected $translationForeignKey = 'brand_id';

    public function trans()
    {
        return $this->hasMany(BrandTranslation::class, 'brand_id', 'id');
    }


    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}

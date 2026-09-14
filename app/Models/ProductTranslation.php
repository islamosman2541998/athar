<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'product_id',
            'locale',
            'title',
            'slug',
            'description',
            'form',
            'category',
            'dispatch',
            'servings',
            'care_tips',
            'meta_title',
            'meta_desc',
            'meta_key',
            'product_id',
        ];


    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id');
    }
    

 }

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategoryTranslation extends Model
{
    use HasFactory;


    // The attributes that are mass assignable.
    protected $fillable = [
        'service_cat_id',
        'locale',
        'title',
        'middle_title',
        'middle_content',
        'slug',
        'description',
        'meta_title',
        'meta_desc',
        'meta_key',
        'info_title',
        'info_description',
    ];

    // Indicates if the model should be timestamped.
    public $timestamps = true;






    // Define the relationship with the ServiceCategory model
    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_cat_id');
    }
}

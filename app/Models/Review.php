<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'type',
        'description',
        'rate',
        'status',
        'feature',
        'customer_name',
        'reviewable_type',
        'reviewable_id',
        'image',
        'created_by',
        'updated_by',
    ];
//    protected $translationForeignKey = 'review_id';
//    public $translatedAttributes = [
//        'review_id',
//        'locale',
//        'title',
//        'slug',
//        'meta_title',
//        'meta_description',
//        'meta_key',
//    ];

    public function reviewable()
    {
        return $this->morphTo();
    }



    // relations ---------------------------------------------------------------------------------
//    public function trans(){
//        return $this->hasMany(ReviewTranslation::class, 'review_id', 'id');
//    }
//
//


    //path of images
    public function path()
    {
        $path = "/attachments/reviews/";
        return $path;
    }


   static public function staticPath()
    {
        $path = "/attachments/reviews/";
        return $path;
    }


    //path of images that showed in view
    public function pathInView()
    {
        if(file_exists(public_path() . $this->path() . $this->image)   && $this->image){
            $path =   $this->path() . $this->image;
        }else{
            $path = '/attachments/no_image/no_image.png';
        }
        return $path;
    }


    /***********scopes***************/
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }



}

<?php

namespace App\Models;

use App\Models\PagesTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pages extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = ['image',  'status', 'created_by', 'updated_by'];
    // transatable table
    public $translatedAttributes = ['page_id', 'locale', 'title', 'slug', 'content','meta_title' ,'meta_description','meta_key'];
    // foreign key
    protected $translationForeignKey = 'page_id';

    public function trans(){
        return $this->hasMany(PagesTranslation::class,'page_id');
    }

    public function transNow(){
        return $this->hasOne(PagesTranslation::class,'page_id')->where('locale' , app()->getLocale());
    }

    // Scopes ----------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeLang($query){
        return $query->trans->where('locale',  app()->getLocale())->first();
    }




    /*******************images part ********************/

    //path of images
    public function path()
    {
        $path = "/attachments/pages/";
        return $path;
    }




    //path of images that showed in view
    public function pathInView()
    {
        if(file_exists(public_path() . '/'  . $this->image)   && $this->image){
            $path =    $this->image;
        }
        else{
            $path = '/attachments/no_image/no_image.png';
        }
        return $path;
    }


    /******************boot model*******************/



    protected static function boot()
    {
        parent::boot();

        // Apply the relationship globally
        static::addGlobalScope('transNow', function (\Illuminate\Contracts\Database\Eloquent\Builder $builder) {
            $builder->with('transNow');
        });
    }

    /******************end boot model**********************/




}

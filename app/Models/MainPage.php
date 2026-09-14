<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo', //
        'first_image',
        'second_image',
        'our_mission_image',
        'phone',
        'email',
        'location',



    ];

    protected $translationForeignKey = 'main_page_id';
    // transatable table
    public $translatedAttributes = ['main_page_id', 'locale', 'company_name' ,         'company_name', //
        'main_title', //
        'main_desc', //
        'services_title',
        'our_mission_desc',
        'happiness_title',
        'organic_title',
        'freshness_title',
        'delivery',
        'main_last_title',
        'main_last_desc',
        'address',
    ];


    /******************boot model*******************/



    protected static function boot()
    {
        parent::boot();

        // Apply the relationship globally
        static::addGlobalScope('transNow', function (Builder $builder) {
            $builder->with('transNow');
        });
    }

    /******************end boot model**********************/


    public function transNow()
    {
         return $this->hasOne(MainPageTranslation::class, 'main_page_id')->where('locale' , app()->getLocale());
    }

    public function trans()
    {
        return $this->hasMany(MainPageTranslation::class, 'main_page_id');
    }


    /*********images********/
    /*******************images part ********************/

    //path of images
    public function path()
    {
        $path = "/attachments/main_page/";
        return $path;
    }




    //path of images that showed in view
    public function pathInView($image_key = '' , $name = 'image')
    {
        if($image_key == null) {
            if (file_exists(public_path() . $this->path() . $this->$name) && $this->$name) {
                $path = $this->path() . $this->$name;
            } else {
                $path = '/attachments/no_image/no_image.png';
            }
        }else{
            if (file_exists(public_path() . $this->path() . $image_key . $this->$name) && $this->$name) {
                $path = $this->path() . $image_key  . $this->$name;
            } else {
                $path = '/attachments/no_image/no_image.png';
            }

        }
        return $path;
    }






}

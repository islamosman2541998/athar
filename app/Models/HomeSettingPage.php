<?php

namespace App\Models;

use App\Models\HomeSettingPageTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeSettingPage extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = ['title_section', 'image', 'status', 'url', 'created_by', 'updated_by'];

    public $translatedAttributes = ['home_setting_id', 'locale', 'title', 'description', 'sub_title'];
    // foreign key
    protected $translationForeignKey = 'home_setting_id';

    public function trans()
    {
        return $this->hasMany(HomeSettingPageTranslation::class, 'home_setting_id');
    }

    public function transNow()
    {
        return $this->hasOne(HomeSettingPageTranslation::class, 'home_setting_id')->where('locale', app()->getLocale());
    }


    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


    /*********images********/
    /*******************images part ********************/



    //path of images that showed in view
    public function pathInView($image_key = '', $name = 'image')
    {
        if (file_exists($this->$name) && $this->$name) {
            $path = $this->$name;
        } else {
            $path = '/attachments/no_image/no_image.png';
        }


        return asset($path);
    }

}

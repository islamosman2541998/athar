<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsAppContact extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    public $translatedAttributes = ['title', 'slug', 'description', 'whats_app_contact_id',
        'locale', 'meta_title', 'meta_description', 'meta_key'];

    protected $fillable = [
        'image',
        'number',
        'status',
        'feature',
    ];


    protected $translationForeignKey = 'whats_app_contact_id';


    public function trans()
    {
        return $this->hasMany(WhatsAppContactTranslation::class, 'whats_app_contact_id');
    }

    public function transNow()
    {
        return $this->hasOne(WhatsAppContactTranslation::class, 'whats_app_contact_id')->where('locale' , app()->getLocale() );
    }


    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }



    /*******************images part ********************/

    //path of images
    public function path()
    {
        $path = "/attachments/whatsapp_contacts/images/";
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

}

<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'unique_name',
        'logo',
        'qr_image',
        'status',
        'minimum_price',
        'number',
        'user_name',
        'updated_by',
    ];


    // transatable table
    public $translatedAttributes = ['payment_method_id', 'locale', 'title', 'description'];
    // foreign key
    protected $translationForeignKey = 'payment_method_id';

    public function trans()
    {
        return $this->hasMany(PaymentMethodTranslation::class, 'payment_method_id');
    }

    public function transNow()
    {
        return $this->hasOne(PaymentMethodTranslation::class, 'payment_method_id')->where('locale', app()->getLocale());
    }


    /**
     * The user who last updated this payment method.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    /**********scopes********/

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }



    /***************path images ***********/

  static  public function staticPath()
    {
        $path = "/attachments/payment_methods/images/";
        return $path;
    }


    //path of images
    public function path()
    {
        $path = "/attachments/payment_methods/images/";
        return $path;
    }


    //path of images that showed in view
    public function pathInView()
    {
        if (file_exists(public_path() . $this->path() . $this->image) && $this->image) {
            $path = $this->path() . $this->image;
        } else {
            $path = '/attachments/no_image/no_image.png';
        }
        return $path;
    }

}

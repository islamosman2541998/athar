<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statistic  extends Model
{
    use HasFactory, SoftDeletes, Translatable;
    protected $table = 'statistic';

    protected $fillable = [

        'image',
        'count',
        'sort',
        'status',
        'feature',
        'created_by',
        'updated_by',
    ];
    protected $translationForeignKey = 'statistic_id';
    public $translatedAttributes = [
        'statistic_id',
        'locale',
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_key',
    ];


    // relations ---------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(StatisticTranslation::class, 'statistic_id', 'id');
    }


  public function transNow()
    {
        return $this->hasOne(StatisticTranslation::class, 'statistic_id')->where('locale', app()->getLocale());
    }

    

    // Scopes ---------------------------------------------------------------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }
}

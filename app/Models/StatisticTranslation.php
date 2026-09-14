<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatisticTranslation extends Model
{
    use HasFactory;
    protected $table = 'statistic_translations';

    protected $fillable = [
        'statistic_id',
        'locale',
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_key',
    ];

    public function scopeLang($query){
        return $query->where('locale',  app()->getLocale())->first();
    }
}

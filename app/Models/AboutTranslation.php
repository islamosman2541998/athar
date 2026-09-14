<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AboutTranslation extends Model
{
    use HasFactory;

    protected $table = 'about_translations';

    protected $fillable = [
        'about_id', 'locale',
        'title','subtitle','description','sub_description',
        'our_story_title','our_story_description',
        'ceo_title','ceo_description',
        'vision','mission','at_a_glance','core_values',
    ];

     protected $casts = [
        'core_values' => 'array', 
    ];

    public function main()
    {
        return $this->belongsTo(About::class, 'about_id', 'id');
    }
}

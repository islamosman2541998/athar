<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTranslation extends Model
{
    use HasFactory;
    protected $table = 'video_translations';

    protected $fillable = [
        'video_id',
        'title',
        'slug',
        'description',
        'locale',
        'meta_title',
        'meta_description',
        'meta_key',
    ];
}

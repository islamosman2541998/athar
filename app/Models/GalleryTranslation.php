<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryTranslation extends Model
{
    use HasFactory;
    protected $table = 'gallery_translations';

    protected $fillable = [
        'galler_id',
        'title',
        'slug',
        'description',
        'locale',
        'meta_title',
        'meta_description',
        'meta_key',
    ];
}

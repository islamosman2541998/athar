<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryGroupTranslation extends Model
{
    use HasFactory;

    protected $table='gallery_groups_translations';
    protected $fillable = [
        'id',
        'gallery_group_id',
        'locale',
        'title',
        'slug',
        'meta_title',
        'meta_desc',
        'meta_key',
    ];
}

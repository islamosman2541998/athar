<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialtiesTranslation extends Model
{
    use HasFactory;
    protected $table = 'specialties_translations';

    protected $fillable = [
        'specialty_id',
        'title',
        'slug',
        'description',
        'locale',
        'meta_title',
        'meta_description',
        'meta_key',
    ];

}

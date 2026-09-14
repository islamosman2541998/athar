<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorTranslation extends Model
{
    use HasFactory;
    protected $table = 'doctor_translations';

    protected $fillable = [
        'doctor_id',
        'title',
        'slug',
        'description',
        'appointments',
        'locale',
        'meta_title',
        'meta_description',
        'meta_key',
    ];
}

<?php

namespace App\Models;

use App\Models\DoctorTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    public $translatedAttributes = ['title', 'slug', 'description', 'appointments',  'doctor_id',
        'locale', 'meta_title', 'meta_description', 'meta_key'];

    protected $fillable = [
        'specialty_id',
        'image',
        'phone',
        'email',
        'address',
        'degree',
        'facebook',
        'twitter',
        'sort',
        'feature',
        'status',
        'created_by',
        'updated_by',
    ];


    protected $translationForeignKey = 'doctor_id';


    public function trans()
    {
        return $this->hasMany(DoctorTranslation::class, 'doctor_id', 'id');
    }


    public function specialty()
    {
        return $this->belongsTo(Specialties::class, 'specialty_id', 'id');
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

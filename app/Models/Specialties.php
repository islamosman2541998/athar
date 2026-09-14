<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialties extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    public $translatedAttributes = ['title', 'slug', 'description', 'specialty_id', 'locale', 'meta_title', 'meta_description', 'meta_key'];

    protected $fillable = [
        'url',
        'sort',
        'image',
        'feature',
        'status',
        'created_by',
        'updated_by',
    ];



    protected $translationForeignKey = 'specialty_id';


    public function trans()
    {
        return $this->hasMany(SpecialtiesTranslation::class, 'specialty_id', 'id');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'specialty_id', 'id')->orderBy('sort', 'ASC')->active();
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

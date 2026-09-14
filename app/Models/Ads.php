<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model',
        'image',
        'link',
    ];
    

    public function projectCategories(){
        return $this->belongsTo(CategoryProjects::class, 'id', 'model_id')->where('model', 'App\Models\CategoryProjects');
    }
}







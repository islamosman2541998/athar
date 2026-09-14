<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategoryOccasion extends Model
{
    protected $table = 'service_category_occassions';
    use HasFactory;

    protected $fillable = [
        'occassion_id', 'category_service_id',
    ];
}

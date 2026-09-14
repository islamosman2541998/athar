<?php

namespace App\Models;

use App\Models\Portfolios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contactus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'subject',
        'message',
        'city',
        'type',
        'status',
        'created_by',
        'updated_by'
    ];
}

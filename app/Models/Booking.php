<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'specialty_id',
        'doctor_id',
        'date',
        'time',
        'message',
        'status',
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialties::class, 'specialty_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

}

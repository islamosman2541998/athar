<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = [
        'job_id',
        'name',
        'email',
        'phone',
        'cv_file',
        'status',
    ];

   
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
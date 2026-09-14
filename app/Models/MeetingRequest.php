<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingRequest extends Model
{
    protected $table = 'meeting_requests';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'meeting_type',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
    ];
}
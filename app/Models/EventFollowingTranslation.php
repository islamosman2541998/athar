<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFollowingTranslation extends Model
{
    protected $table = 'event_following_translations';
    protected $fillable = ['event_following_id', 'locale', 'title', 'description'];
}
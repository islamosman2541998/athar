<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppContactTranslation extends Model
{


    use HasFactory;
    protected $fillable = [
        'whats_app_contact_id',
        'title',
        'slug',
        'description',
        'locale',
        'meta_title',
        'meta_description',
        'meta_key',
    ];
}

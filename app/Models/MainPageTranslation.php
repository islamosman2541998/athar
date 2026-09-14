<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainPageTranslation extends Model
{
    use HasFactory;

    protected $table = 'main_pages_translations';
    protected $fillable = [
        'main_page_id',
        'locale',
        'company_name', //
        'main_title', //
        'main_desc', //
        'services_title',
        'our_mission_desc',
        'happiness_title',
        'organic_title',
        'freshness_title',
        'delivery',
        'main_last_title',
        'main_last_desc',
        'address',

    ];
}

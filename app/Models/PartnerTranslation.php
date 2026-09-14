<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['partner_id','locale','title'];
}

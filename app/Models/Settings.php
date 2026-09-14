<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;


    protected $fillable = ['key', 'status'];

    
    public function values(){
        return $this->hasMany(SettingsValues::class, 'setting_id', 'id');
    }
}

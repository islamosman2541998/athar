<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable= ['cookeries' , 'deleted_at'];

    public function carts()
    {
        return $this->hasMany(Cart::class , 'cart_group_id');
    }
}

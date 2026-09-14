<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodTranslation extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'locale',
        'payment_method_id',
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPaymentLineTranslation extends Model
{
    protected $table = 'product_payment_line_translations';

    protected $fillable = [
        'payment_line_id',
        'locale',
        'title',
    ];
}
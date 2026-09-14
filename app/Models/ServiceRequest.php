<?php

namespace App\Models;

use App\Models\Services;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class ServiceRequest extends Model
{

        protected $table = 'service_request';

    protected $fillable = [
        'service_category_id',
        'name',
        'email',
        'phone',
        'attachment',
        'company',
        'message',
        'timeline',
        
    ];

   
    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
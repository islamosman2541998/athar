<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return  [
            'title' => '',
            'unique_name',
            'qr_image',
            'status',
            'minimum_price',
            'number',
            'user_name',
            'description',
            'updated_by',
        ];
    }
}

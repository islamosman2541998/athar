<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderApiRequest extends FormRequest
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
        return [
            'order_cookie' => 'nullable|string',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id', // Assuming `Product` model
            'rate' => 'required|array',
            'rate.*' => 'integer|between:1,5', // Assuming rating is between 1 and 5
        ];
    }
}

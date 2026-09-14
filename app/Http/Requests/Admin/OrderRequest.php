<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
 use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'status' => [
                'nullable',
                // Check unique combination of status and order_id
                Rule::unique('order_statuses')->where(function ($query) {
                    return $query->where('order_id', $this->id);
                }),
            ],
            'id' => 'required|integer',



            'shipped_status' => [
                'nullable',
                // Check unique combination of status and order_id
                Rule::unique('shipping_order_statuses')->where(function ($query) {
                    return $query->where('order_id', $this->id);
                }),
            ],

        ];
    }
}

<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'customer_name' =>   'string|unique:reviews|max:190|min:3|required' ,
            'description' => 'string|min:3|required' ,
//            'rate' =>  'integer|max:5|min:0|required' ,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'   ,

        ];
    }
}

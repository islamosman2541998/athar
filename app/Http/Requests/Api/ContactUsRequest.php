<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'message' => 'required|string|min:5|max:500',
        ];

    }

    public function getSanitized(){
        $data = $this->validated();

        return $data;
    }
}

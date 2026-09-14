<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class ContactUSRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'nullable',
            'message' => 'nullable',
            'phone' => 'nullable',
            'city' => 'nullable',
            'type' => 'nullable',
            'status' => 'nullable',
            'created_by' => 'nullable',
            'updated_by' => 'nullable',
        ];
       
    }

    public function getSanitized(){
        $data = $this->validated();
        
        return $data;
    }
}

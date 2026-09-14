<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
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

        $req = [];
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'required'];
        }
        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['status' => 'nullable'];
        return $req;
    }


    public function getSanitized()
    {
        $data = $this->validated();
        $data['status'] = isset($data['status']) ? true : false;
        return $data;
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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

        $req = [];
        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'required'];
            $req += [$locale . '.slug' => 'required'];
            $req += [$locale . '.description' => 'nullable'];
            $req += [$locale . '.appointments' => 'nullable'];

            $req += [$locale . '.meta_title' => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key' => 'nullable'];
        }
        $req += ['specialty_id' => 'required'];
        $req += ['phone' => 'nullable'];
        $req += ['email' => 'nullable'];
        $req += ['address' => 'nullable'];
        $req += ['degree' => 'nullable'];
        $req += ['facebook' => 'nullable'];
        $req += ['twitter' => 'nullable'];
        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['status' => 'nullable'];
        $req += ['sort' => 'nullable'];
        $req += ['feature' => 'nullable'];
        $req += ['updated_by' => 'nullable'];
        $req += ['created_by' => 'nullable'];

       return $req;
    }



    public function getSanitized()
    {
        $data = $this->validated();

        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['slug'] = slug($data[$locale]['slug']);
        }
        if (request()->isMethod('PUT')) {
            $data['updated_by']  = @auth()->user()->id;
        } else {
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}

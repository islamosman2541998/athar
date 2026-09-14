<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReviewsRequest extends FormRequest
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
//        foreach (config('translatable.locales') as $locale) {
//            $req += [$locale . '.title' => 'required'];
//            $req += [$locale . '.slug' => 'required'];
//            $req += [$locale . '.type' => 'required'];
//            $req += [$locale . '.description' => 'nullable'];
//
//            $req += [$locale . '.meta_title' => 'nullable'];
//            $req += [$locale . '.meta_description' => 'nullable'];
//            $req += [$locale . '.meta_key' => 'nullable'];
//        }
        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['status' => 'nullable'];
        $req += ['feature' => 'nullable'];
        if (request()->isMethod('post')) {
            $req += ['customer_name' => 'string|unique:reviews|max:190|min:3|required'];
        } else {
            $req += ['customer_name' => 'string|max:190|min:3|required'];
        }
        $req += ['description' => 'string|min:3|required'];


        return $req;
    }


    public function getSanitized()
    {
        $data = $this->validated();

        $data['status'] = isset($data['status']) ? true : false;
        $data['feature'] = isset($data['feature']) ? true : false;
        if (request()->isMethod('PUT')) {
            $data['updated_by'] = @auth()->user()->id;
        } else {
            $data['created_by'] = @auth()->user()->id;
        }
        return $data;
    }
}

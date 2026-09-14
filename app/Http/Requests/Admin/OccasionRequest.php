<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OccasionRequest extends FormRequest
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
        $arr = [];

        $arr += ['ar' => 'required|array'];
        $arr += ['en' => 'required|array'];

        foreach (config('translatable.locales') as $locale) {
            $arr += [$locale . '.title' => 'required|min:1|max:255'];
            $arr += [$locale . '.description' => 'nullable|min:1'];
        }
        $arr += ['image' => 'nullable|' . ImageValidate()];


        $arr += ['status' =>'nullable'];
        $arr += ['sort' =>'nullable'];
        $arr += ['feature' =>'nullable'];



//        if (request()->isMethod('POST')) {
//            $arr['image'] = 'nullable|' . ImageValidate();
//        }

        return $arr;
    }
}

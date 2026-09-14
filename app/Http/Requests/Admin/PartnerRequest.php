<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{
    public function authorize()
     { return true;
     }

    public function rules()
    {
        $rules = [
            'image' => 'nullable|image|max:4096',
            'url' => 'nullable|url|max:255',
            'status' => 'nullable|boolean',
            'sort' => 'nullable|integer',
        ];

        foreach(config('translatable.locales') as $locale){
            $rules["{$locale}.title"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $locales = config('translatable.locales', ['en']);
        $rules = [
            'image' => 'nullable|image|max:5120', 
            'image_background' => 'nullable|image|max:5120',
            'ceo_image' => 'nullable|image|max:5120',
            'sort' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ];
  
        foreach ($locales as $locale) {
            $rules["{$locale}.title"] = 'nullable|string|max:255';
            $rules["{$locale}.subtitle"] = 'nullable|string|max:255';
            $rules["{$locale}.description"] = 'nullable|string';
            $rules["{$locale}.sub_description"] = 'nullable|string';
            $rules["{$locale}.our_story_title"] = 'nullable|string|max:255';
            $rules["{$locale}.our_story_description"] = 'nullable|string';
            $rules["{$locale}.ceo_title"] = 'nullable|string|max:255';
            $rules["{$locale}.ceo_description"] = 'nullable|string';
            $rules["{$locale}.vision"] = 'nullable|string';
            $rules["{$locale}.mission"] = 'nullable|string';
            $rules["{$locale}.at_a_glance"] = 'nullable|string';
    
            
        }


        return $rules;
    }
}

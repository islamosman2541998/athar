<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    public function authorize()
     { 
        return true; 
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'feature' => $this->has('feature') ? 1 : 0,
            'status'  => $this->has('status') ? 1 : 0,
        ]);
    }
    public function rules()
    {
        $rules = [
            'employment_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:191',
            'image' => 'nullable|image|max:2048',
            'status' => 'nullable',
            'feature' => 'nullable',
            'sort' => 'nullable|integer',
            'career_category_id' => 'required|integer|exists:career_categories,id',
        ];

        // per-locale fields
        foreach (config('translatable.locales') as $locale) {
            $rules["{$locale}.title"] = 'nullable|string|max:255';
            $rules["{$locale}.short_description"] = 'nullable|string|max:500';
            $rules["{$locale}.description"] = 'nullable|string';
            $rules["{$locale}.job_desc"] = 'nullable|string';
            $rules["{$locale}.requirements"] = 'nullable|string';
            $rules["{$locale}.slug"] = 'nullable|string|max:255';
            $rules["{$locale}.meta_title"] = 'nullable|string|max:255';
            $rules["{$locale}.meta_desc"] = 'nullable|string|max:255';
            $rules["{$locale}.meta_key"] = 'nullable|string|max:255';
            
        }

        // tags array optional
        $rules['tags'] = 'nullable|array';
        $rules['tags.*'] = 'nullable|integer|exists:tags,id';

        return $rules;
    }
}


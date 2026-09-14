<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class FaqCategoryRequest extends FormRequest {
    public function authorize(){ return true; }

    public function rules(){
        $rules = [
            'sort' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["{$locale}.title"] = 'required|string|max:255';
            $rules["{$locale}.slug"] = 'nullable|string|max:255';
        }

        return $rules;
    }
}

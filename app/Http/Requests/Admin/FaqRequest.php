<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest {
    public function authorize(){ return true; }

    public function rules(){
        $rules = [
            'faq_category_id' => 'nullable|exists:faq_categories,id',
            'sort' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["{$locale}.question"] = 'nullable|string|max:255';
            $rules["{$locale}.answer"] = 'nullable|string';
        }

        return $rules;
    }
}

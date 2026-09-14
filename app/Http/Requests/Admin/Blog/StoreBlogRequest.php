<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
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
        $arr = [];

        $arr += ['ar' => 'required|array'];
        $arr += ['en' => 'required|array'];

        foreach (config('translatable.locales') as $locale) {
            $arr += [$locale . '.title' => 'required|min:1'];
            $arr += [$locale . '.slug' => 'required|min:1'];
            $arr += [$locale . '.description' => 'nullable|min:1'];
        


            $arr += [$locale . '.meta_title' => 'nullable|min:1'];
            $arr += [$locale . '.meta_desc' => 'nullable|min:1'];
            $arr += [$locale . '.meta_key' => 'nullable|min:1'];
        }
        $arr += ['image' => 'nullable|' . ImageValidate()];



        $arr += ['url' => 'nullable|url'];

  
        $arr += ['sort' => 'nullable|integer|min:0'];
        $arr += ['feature' => 'nullable'];
        $arr += ['status' => 'nullable'];
       


  

        $arr += ['lines.*.id' => 'nullable'];
        $arr += ['lines.*.title' => 'nullable|array'];
        $arr += ['lines.*.title.en' => 'nullable|string|max:255'];
        $arr += ['lines.*.title.ar' => 'nullable|string|max:255'];
        
        $arr += ['lines.*.sort' => 'nullable'];
        $arr += ['lines.*.status' => 'nullable'];

        $arr += ['tips.*.id' => 'nullable'];
        $arr += ['tips.*.title' => 'nullable|array'];
        $arr += ['tips.*.title.en' => 'nullable|string|max:255'];
        $arr += ['tips.*.title.ar' => 'nullable|string|max:255'];
        $arr += ['tips.*.description' => 'nullable|array'];
        $arr += ['tips.*.description.en' => 'nullable|string'];
        $arr += ['tips.*.description.ar' => 'nullable|string'];
        $arr += ['tips.*.sort' => 'nullable'];
        $arr += ['tips.*.status' => 'nullable'];

        $arr += ['info.*.id' => 'nullable'];
        $arr += ['info.*.title' => 'nullable|array'];
        $arr += ['info.*.title.en' => 'nullable|string|max:255'];
        $arr += ['info.*.title.ar' => 'nullable|string|max:255'];
        $arr += ['info.*.description' => 'nullable|array'];
        $arr += ['info.*.description.en' => 'nullable|string'];
        $arr += ['info.*.description.ar' => 'nullable|string'];
        $arr += ['info.*.sort' => 'nullable'];
        $arr += ['info.*.status' => 'nullable'];

       

        if (request()->isMethod('POST')) {
            $arr['image'] = 'nullable|' . ImageValidate();
        }

        return $arr;
    }




    public function getSanitized()
    {
        $data = $this->validated();

        $data['status'] = isset($data['status']) ? 1 : 0;
        $data['feature'] = isset($data['feature']) ? 1 : 0;
      

        

        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['slug'] = slug($data[$locale]['slug']);
        }
        
        return $data;
    }
}
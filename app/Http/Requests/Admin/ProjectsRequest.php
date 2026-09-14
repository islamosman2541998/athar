<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Locale;

class ProjectsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules() {
        $req = [];
        foreach(config('translatable.locales') as $locale){
            $req += [$locale . '.title' => 'required'];

            $req += [$locale . '.meta_title' => 'nullable'];
            $req += [$locale . '.meta_description' => 'nullable'];
            $req += [$locale . '.meta_key' => 'nullable'];
        }
        $this->isMethod('POST') ?
                $req += ['image' =>'required|' . ImageValidate()] :
                $req += ['image' =>'nullable|' . ImageValidate()];

        $req += ['portfolio_id' =>'required'];
        $req += ['status' =>'nullable'];
        $req += ['sort' =>'nullable'];
        $req += ['gallery' =>'nullable|array'];
        $req += ['newgallery' =>'nullable|array'];

        return $req;
    }

    public function getSanitized(){
        $data = $this->validated();
        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['slug'] = slug($data[$locale]['title']);
        }
        $data['status'] = isset($data['status']) ? true : false;

        if (request()->isMethod('PUT')){
            $data['updated_by']  = @auth()->user()->id;
        }
        else{
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }
}

<?php

namespace App\Http\Requests\Admin;

use App\Models\ProductCategory;
use App\Traits\FileHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductCategoryRequest extends FormRequest
{

    use FileHandler;


    public $productPath;
    public $galleryPath;


    public function __construct()
    {
        $this->productPath = '/attachments/product_category/main_images/';
        $this->galleryPath = "/attachments/gallery/product_category/";
    }



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





        $arr +=  ['gallery_sort'  => 'nullable|array'];
        $arr +=  ['gallery_sort.*'  => 'nullable|integer'];

        $arr +=  ['gallery_title'  => 'nullable|array'];
        $arr +=  ['gallery_title.*'  => 'nullable|string'];

        $arr +=  ['gallery_feature'  => 'nullable|array'];
        $arr +=  ['gallery_feature.*'  => 'nullable|integer'];

        $arr +=  ['gallery_image'  => 'nullable|array'];
        $arr +=  ['gallery_image.*'  => 'nullable|'. ImageValidate()];


        $arr += ['status' =>'nullable'];
        $arr += ['sort' =>'nullable'];
        $arr += ['feature' =>'nullable'];
        $arr += ['annual_occasion' => 'sometimes|boolean'];
        $arr += ['show_in_bottom' => 'sometimes|boolean'];
        

        $arr +=  ['occasions'  => 'nullable|array'];
        $arr +=  ['occasions.*'  => 'nullable|exists:occassions,id'];


        if (request()->isMethod('POST')) {
            $arr['image'] = 'nullable|' . ImageValidate();
        }

        return $arr;
    }


    public function getSanitized(   ){

        $data =  $this->validated();


        if (request()->image) {
            $img = $this->storeImage2(request(), $this->productPath, request()->image, 'image');
            $data['image'] = $img;
        }

        
        $data['status'] = isset($data['status']) ? 1 : 0;
        $data['feature'] = isset($data['feature']) ? 1 : 0;
        $data['annual_occasion']  = isset($data['annual_occasion'])  ? 1 : 0;
        $data['show_in_bottom']  = isset($data['show_in_bottom'])  ? 1 : 0;
        
        

        foreach(config('translatable.locales') as $locale){
            $data[$locale]['slug'] = slug($data[$locale]['slug']);
        }
        if (request()->isMethod('PUT')){
            $data['updated_by']  = @auth()->user()->id;
        }
        else{
            $data['created_by']  = @auth()->user()->id;
        }
        return $data;
    }


}
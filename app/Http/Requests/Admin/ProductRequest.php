<?php

namespace App\Http\Requests\Admin;

use App\Traits\FileHandler;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    use FileHandler;
    public $products;
    public $productPath;
    public $galleryPath;


    public function __construct()
    {
        $this->productPath = '/attachments/products/';
        $this->galleryPath = "/attachments/gallery/products/";
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
     protected function prepareForValidation()
    {
        $this->merge([
            'has_pockets' => $this->has('has_pockets') ? 1 : 0,
            
        ]);
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
            $arr += [$locale . '.care_tips' => 'nullable|min:1'];
            $arr += [$locale . '.servings' => 'nullable|min:1'];
            $arr += [$locale . '.form' => 'nullable|min:1'];
            $arr += [$locale . '.category' => 'nullable|min:1'];
            $arr += [$locale . '.dispatch' => 'nullable|min:1'];


            $arr += [$locale . '.meta_title' => 'nullable|min:1'];
            $arr += [$locale . '.meta_desc' => 'nullable|min:1'];
            $arr += [$locale . '.meta_key' => 'nullable|min:1'];
        }
        $arr += ['image' => 'nullable|' . ImageValidate()];



        $arr += ['url' => 'nullable|url'];

        $arr += ['price' => 'required|numeric|min:0'];
        $arr += ['sale' => 'nullable|numeric|min:0'];
        $arr += ['price_after_sale' => 'nullable|numeric|min:0'];
        $arr += ['code' => 'nullable'];
        $arr += ['sort' => 'nullable|integer|min:0'];
        $arr += ['feature' => 'nullable'];
        $arr += ['status' => 'nullable'];
        $arr += ['show_in_slider' => 'nullable'];
        $arr += ['in_stock' => 'nullable'];
        $arr += ['show_text' => 'nullable'];
        $arr += ['user_input' => 'nullable'];
        $arr += ['product_cart' => 'nullable'];


        $arr += ['categories' => 'nullable|array'];
        $arr += ['categories.*' => 'nullable|exists:product_categories,id'];
        $arr += ['occasions' => 'nullable|array'];
        $arr += ['occasions.*' => 'nullable|exists:occassions,id'];


        $arr += ['lines.*.id' => 'nullable'];
        $arr += ['lines.*.title' => 'nullable|array'];
        $arr += ['lines.*.title.en' => 'nullable|string|max:255'];
        $arr += ['lines.*.title.ar' => 'nullable|string|max:255'];
        $arr += ['lines.*.links' => 'nullable'];
        $arr += ['lines.*.color' => 'nullable'];
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

        $arr['has_pockets']    = 'nullable';
        if ($this->has('pockets')) {
            $arr['pockets.en.*']    = 'nullable|string|max:255';
            $arr['pockets.ar.*']    = 'nullable|string|max:255';
            $arr['pockets.price.*'] = 'nullable|numeric|min:0';
            $arr['pockets.image.*'] = 'nullable|array';
            $arr['pockets.image.*.*'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        if (request()->isMethod('POST')) {
            $arr['image'] = 'required|' . ImageValidate();
        }

        return $arr;
    }




    public function getSanitized()
    {
        $data = $this->validated();

        $data['status'] = isset($data['status']) ? 1 : 0;
        $data['show_in_slider'] = isset($data['show_in_slider']) ? 1 : 0;
        $data['feature'] = isset($data['feature']) ? 1 : 0;
        $data['in_stock'] = isset($data['in_stock']) ? 1 : 0;
        $data['show_text'] = isset($data['show_text']) ? 1 : 0;
        $data['user_input'] = isset($data['user_input']) ? 1 : 0;
        $data['product_cart'] = isset($data['product_cart']) ? 1 : 0;

        if (isset($data['pockets']['en']) && is_array($data['pockets']['en'])) {
            foreach ($data['pockets']['en'] as $key => $price) {
                $data['pockets']['price'][$key] = is_numeric(@$data['pockets']['price'][$key]) ? $price : 0;

                if (isset($data['pockets']['image'][$key]) && is_string($data['pockets']['image'][$key])) {
                    $data['pockets']['image'][$key] = $this->uploadFile($data['pockets']['image'][$key], $this->productPath);
                }
            }
        }

        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['slug'] = slug($data[$locale]['slug']);
        }
        if (request()->isMethod('PUT')) {
            $data['updated_by'] = @auth()->user()->id;
        } else {
            $data['created_by'] = @auth()->user()->id;
        }
        return $data;
    }
}

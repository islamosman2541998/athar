<?php

namespace App\Http\Requests\Admin;

use App\Traits\FileHandler;
use Illuminate\Foundation\Http\FormRequest;

class ServiceCategoryRequest extends FormRequest
{
    use FileHandler;
    public $galleryPath;
    public $serviceCategory_categoryPath;
    public $infoImagePath;
    public $followingImagePath;



    public function __construct()
    {


        $this->serviceCategory_categoryPath = '/attachments/service_category/main_images/';
        $this->galleryPath = "/attachments/gallery/service_category/";
        $this->infoImagePath = '/attachments/service_category/info_images/';
    $this->followingImagePath = '/attachments/service_category/followings/';


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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */


   public function rules()
{
    $arr = [];

    // existing localized fields
    $arr += ['ar' => 'required|array'];
    $arr += ['en' => 'required|array'];

    foreach (config('translatable.locales') as $locale) {
        $arr += [$locale . '.title'             => 'required|min:1'];
        $arr += [$locale . '.slug'              => 'required|min:1'];
        $arr += [$locale . '.description'       => 'required|min:1'];
        $arr += [$locale . '.middle_title'      => 'nullable|min:1'];
        $arr += [$locale . '.middle_content'    => 'nullable|min:1'];

        $arr += [$locale . '.meta_title'        => 'nullable|min:1'];
        $arr += [$locale . '.meta_desc'         => 'nullable|min:1'];
        $arr += [$locale . '.meta_key'          => 'nullable|min:1'];
        $arr += [$locale . '.info_title'        => 'nullable|string|min:1'];
        $arr += [$locale . '.info_description'  => 'nullable|string|min:1'];
    }

    // main image & flags
    $arr += ['image'   => 'nullable|' . ImageValidate()];
    $arr += ['sort'    => 'required|integer|min:0'];
    $arr += ['feature' => 'nullable|integer'];
    $arr += ['status'  => 'nullable|integer'];

    // info_image on create
    if (request()->isMethod('POST')) {
        $arr['image']      = 'required|' . ImageValidate();
        $arr['info_image'] = 'nullable|' . ImageValidate();
    }

    // gallery group
    $arr += ['new_following'             => 'nullable|array'];
    $arr += ['new_following.*.image'     => 'required|' . ImageValidate()];
    foreach (config('translatable.locales') as $locale) {
        $arr += ['new_following.*.' . $locale . '.title'       => 'nullable|string|min:1'];
        $arr += ['new_following.*.' . $locale . '.description' => 'nullable|string|min:1'];
    }

    // existing followings uploads & translations
    $arr += ['following'             => 'nullable|array'];
    $arr += ['following.*.image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'];
    foreach (config('translatable.locales') as $locale) {
        $arr += ['following.*.' . $locale . '.title'       => 'nullable|string|min:1'];
        $arr += ['following.*.' . $locale . '.description' => 'nullable|string|min:1'];
    }

    return $arr;
}



    public function getSanitized()
    {

        $data = $this->validated();


        if (request()->image) {
            $img = $this->storeImage2(request(), $this->serviceCategory_categoryPath, request()->image, 'image');
            $data['image'] = $img;
        }

        // ——— info image ———
    if ($this->hasFile('info_image')) {
        $infoImg = $this->storeImage2(
            $this,
            $this->infoImagePath,
            $this->file('info_image'),
            'info_image'
        );
        $data['info_image'] = $infoImg;
    }


        $data['status'] = isset($data['status']) ? 1 : 0;
        $data['feature'] = isset($data['feature']) ? 1 : 0;

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

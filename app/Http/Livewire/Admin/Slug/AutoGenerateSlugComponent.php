<?php

namespace App\Http\Livewire\Admin\Slug;

use Illuminate\Support\Str;
use Livewire\Component;

class AutoGenerateSlugComponent extends Component
{
    public $title , $slug , $message;
    public $locale;
    public $model;

    public function mount($locale = null , $model = null) // to pass a parameter inside livewire blade compoonent
    {
        $this->locale = $locale;
        $this->model = $model;

        $this->title = $model->title ?? '';
        $this->slug = $model->slug ?? '';

    }


//    public function updateSlug(){
//        $this->slug = Str::slug($this->title);
//    }




    public function updateSlug()
    {
        $this->slug = $this->generateArabicSlug($this->title);
    }

    private function generateArabicSlug($string)
    {
        $string = $this->normalizeArabic($string);
        $string = preg_replace('/[^\p{L}\p{N}\s]/u', '-', $string);
        $string = preg_replace('/[-\s]+/', '-', $string);
        $string = trim($string, '-');
        return strtolower($string);
    }

    private function normalizeArabic($string)
    {
        $string = str_replace(['ـ'], '', $string); // Remove Arabic tatweel
        $string = preg_replace('/\s+/', ' ', $string);
        return $string;
    }

    public function render()
    {
        return view('livewire.admin.slug.auto-generate-slug-component');
    }
}
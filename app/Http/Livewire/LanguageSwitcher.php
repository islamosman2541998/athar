<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageSwitcher extends Component
{
    public $currentLang;

    public function mount()
    {
        $this->currentLang = app()->getLocale();
    }
    public function changeLanguage($language)
    {
        if (in_array($language, ['en', 'ar'])) {
            session()->put('locale', $language);
            app()->setLocale($language);
            $this->redirect(request()->header('referer'));
        }
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
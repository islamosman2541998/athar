<?php

namespace App\View\Components\Site\Layouts;

use Illuminate\View\Component;
use App\Settings\SettingSingleton;
use Illuminate\Support\Facades\Route;

class Head extends Component
{
    public $title;
    public $currentLang;
    public $settings;
    public $pageName;

    public function __construct()
    {

        $this->currentLang = app()->getLocale();
        $this->settings = SettingSingleton::getInstance();
        $this->pageName = $this->getPageNameFromRoute();
        $this->title = $this->getDynamicTitle();
    }

    private function getPageNameFromRoute()
    {
        $routeName = Route::currentRouteName();
        $routes = [
            'site.home' => 'home',
            'site.gallery.index' => 'gallery',
            'site.offers.index' => 'offers',
            'site.services.index' => 'services',
            'site.specialites' => 'specialites',
        ];
        return $routes[$routeName] ?? 'home';
    }

    private function getDynamicTitle()
    {
        $siteName = $this->settings->getItem('site_name') ?? 'Dalia El Haggar - Where Beauty Blooms';
        $metaTitle = $this->settings->getMeta($this->pageName . '_meta_title_' . $this->currentLang) ?? 'Default Title';

        return $siteName . ' | ' . $metaTitle;
    }

    public function render()
    {
        return view('components.site.layouts.head');
    }
}
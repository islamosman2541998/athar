<?php

namespace App\View\Components\Site\Layouts;

use App\Models\Menue;
use App\Settings\HomeSettingSingleton;
use Illuminate\View\Component;
use App\Settings\SettingSingleton;
use Illuminate\Support\Facades\Cache;

class Footer extends Component
{

    public $settings, $homeSetting;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settings = SettingSingleton::getInstance();
        $this->homeSetting = HomeSettingSingleton::getInstance();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $footerMenus = Cache::get('footer-menus');
        
        if( $footerMenus == null){
            $footerMenus = Cache::rememberForever('footer-menus', function () {
                return Menue::with('trans', 'children', 'children.trans')->orderBy('sort', 'ASC')->Footer()->active()->get();
            });
        }
        return view('components.site.layouts.footer', compact('footerMenus'));
    }
}

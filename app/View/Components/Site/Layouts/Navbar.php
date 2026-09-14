<?php

namespace App\View\Components\Site\Layouts;
use App\Models\Menue;
use App\Settings\SettingSingleton;

use Illuminate\Support\Facades\App;
use Illuminate\View\Component;


use App\Enums\MenuPositionEnums;

class Navbar extends Component
{
    public $mainLinks;
    public $mainTitle;
    public $settings;
    public $menus;

   
        public function __construct()
{
    $this->menus = Menue::with('trans')->main()->active()->get(); 
    $currentLang = App::getLocale();
    $this->settings = SettingSingleton::getInstance();
    $this->mainTitle = $this->settings->getItem('main_title_' . $currentLang);

        
    }


    public function render()
    {
        return view('components.site.layouts.navbar');
    }
}




// <?php

// namespace App\View\Components\Site\Layouts;

// use Illuminate\View\Component;
// use App\Settings\SettingSingleton;
// use App\Models\Menue;
// use Illuminate\Support\Facades\App;

// use App\Enums\MenuPositionEnums;

// class Navbar extends Component
// {
//     public $currentLang;
//     public $settings;
//     public $menus;

//     public function __construct($currentLang = 'en')
//     {
//         $this->currentLang = $currentLang;
//         $this->settings = SettingSingleton::getInstance();
//         $this->menus = Menue::with('trans')
//             ->main() 
//             ->active() 
//             ->orderBy('sort', 'ASC') 
//             ->get();
//     }

//     public function render()
//     {
//         return view('components.site.layouts.navbar');
//     }
// }
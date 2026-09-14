<?php

namespace App\View\Components;

use App\Models\Menue;
use App\Models\Portfolios;
use App\Models\PortfolioTags;
use App\Models\SettingsValues;
use Illuminate\View\Component;
use App\Settings\SettingSingleton;
use Illuminate\Support\Facades\App;

class Footer extends Component
{
    public $footerLinks;
    public $footerTitle;
    public $tiktokLink;
    public $linkedinLink;
    public $footerDescription;
    public $cards;
    public $site_name;
    public $maps;
    public $logo;
    public $mobile;
    public $email;
    public $address;
    public $settings;
    public $facebookLink;
    public $instagramLink;

    public $our_work;


    public function __construct()
    {

        $currentLang = App::getLocale();

        $this->settings = SettingSingleton::getInstance();

        $this->footerLinks = Menue::with('trans')->orderBy('sort', 'ASC')->footer()->active()->get();


       $this->our_work = PortfolioTags::active()
    ->feature()
    ->with('transNow')
    ->orderBy('sort', 'ASC')
    ->take(5)
    ->get();

           
        $this->facebookLink = $this->settings->getItem('facebook') ?? 'not found';
        $this->instagramLink = $this->settings->getItem('instagram') ?? 'not found';
        $this->tiktokLink = $this->settings->getItem('tiktok') ?? 'not found';
        $this->linkedinLink = $this->settings->getItem('linkedin') ?? 'not found';
        $this->site_name = $this->settings->getItem('site_name') ?? 'not found';
        $this->maps = $this->settings->getItem('maps') ?? 'not found';
        $this->logo = $this->settings->getItem('logo') ?? 'not found';
        $this->address = $this->settings->getItem('address') ?? 'not found';
        $this->mobile = $this->settings->getItem('mobile') ?? 'not found';
        $this->email = $this->settings->getItem('email') ?? 'not found';
    }

    public function render()
    {
        return view('components.footer');
    }
}

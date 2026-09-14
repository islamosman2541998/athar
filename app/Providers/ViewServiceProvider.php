<?php

namespace App\Providers;

use view;
use App\Models\SettingsValues;
use App\Models\WhatsAppContact;
use App\Models\Menue;
use App\Models\HomeSettingPage;
use App\Models\ServiceCategory;
use App\Settings\SettingSingleton;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }


    public function boot()
    {
        view()->composer('site.layouts.app', function ($view) {
            $menuQuery = fn (string $position) => Menue::query()
                ->where('position', $position)
                ->whereNull('parent_id')
                ->active()
                ->with(['translations', 'childrenRecursive'])
                ->orderByRaw('sort IS NULL, sort ASC')
                ->orderBy('id')
                ->get();

            $view->with([
                'mainMenus' => $menuQuery('main'),
                'footerMenus' => $menuQuery('footer'),
                'ctaSection' => HomeSettingPage::query()
                    ->with('transNow')
                    ->active()
                    ->where('title_section', 'cta')
                    ->first()?->transNow,
            ]);
        });

        view()->composer('site.includes.footer', function ($view) {
            $view->with('footerServices', ServiceCategory::query()
                ->with('transNow')
                ->active()
                ->orderByRaw('sort IS NULL, sort ASC')
                ->take(5)
                ->get());
        });

        if (Schema::hasTable('settings_values')) {
            $currentLang = app()->getLocale();

            // $settings  = @SettingsValues::query();
            $settings  = SettingSingleton::getInstance();


            // $contacts = WhatsAppContact::active()->with(relations: 'transNow')->get();

            // view()->share('contacts', $contacts);

            //  meta setting  ---------------------------------------------------------
            $metaSetting =  $settings->getMetaSetting();

            //  Site  setting  ---------------------------------------------------------
            $settingsSite = $settings->getSiteSetting();

            if ($settingsSite != null) {
                $SiteSetting['site_name'] = @$settingsSite->where('key', 'site_name_' . $currentLang)->first()->value;
                $SiteSetting['logo'] = @$settingsSite->where('key', 'logo_' . $currentLang)->first()->value;
                $SiteSetting['icon'] = @$settingsSite->where('key', 'icon')->first()->value;

                view()->share('metaSetting', $metaSetting);
                view()->share('SiteSetting', $SiteSetting);
            }
        }
    }
}

<?php

namespace App\Settings;

use App\Models\Settings;


class SettingSingleton
{
    private static $instance;
    private $settings;
    private $siteSetting, $colorsSetting, $scriptSetting, $infoSetting, $home_setting , $metaSetting, $viewSetting, $couponSetting, $upperNotify, $fontSetting;

    private function __construct() {}

    public static function getInstance()

    {
        if (!self::$instance) {
            self::$instance = new SettingSingleton();
            self::$instance->loadSettingDatabase();
        }
        return self::$instance;
    }


    private function loadSettingDatabase()
    {
        // Code to retrieve header and footer content from the database
        // Example:

        $this->settings = Settings::with('values')->get();

        $this->siteSetting = (clone $this->settings)->where('key', 'site_setting')->first()?->values;

        $this->metaSetting = (clone $this->settings)->where('key', 'meta_setting')->first()?->values;

        $this->colorsSetting = (clone $this->settings)->where('key', 'color_setting')->first()?->values;

        $this->infoSetting = (clone $this->settings)->where('key', 'info_setting')->first()?->values;

        $this->viewSetting = (clone $this->settings)->where('key', 'home_setting')->first()?->values;

        $this->couponSetting = (clone $this->settings)->where('key', 'coupon_setting')->first()?->values;

        $this->upperNotify = (clone $this->settings)->where('key', 'upper_notify_setting')->first()?->values;
        $this->scriptSetting = (clone $this->settings)->where('key', 'header_scripts')->first()?->values;
        $this->home_setting = (clone $this->settings)->where('key', 'home_setting')->first()?->values;
        $this->fontSetting = (clone $this->settings)->where('key', 'font_setting')->first()?->values;

    }

    public function getFontSetting()
    {
        return $this->fontSetting;
    }

    public function getSiteSetting()
    {
        return $this->siteSetting;
    }

    // public function getsocialSetting()
    // {
    //     return $this->socialSetting;
    // }

    public function getCouponSetting()
    {
        return $this->couponSetting;
    }
    public function getupperNotifySetting()
    {
        return $this->upperNotify;
    }
    public function getScriptSetting()
    {
        return $this->scriptSetting;
    }
    public function getHomeSetting()
    {
        return $this->home_setting;
    }

    public function getColorSetting()
    {
        return $this->colorsSetting;
    }

    public function getInfoSetting()
    {
        return $this->infoSetting;
    }
    public function getMetaSetting()
    {
        return $this->metaSetting;
    }

    public function getViewSetting()
    {
        return $this->viewSetting;
    }

    public function getItem($val)
    {
        $value = "";
        if (substr($val, -3) == "_en" || substr($val, -2) ==  "_ar") {
            $val = substr($val, 0, -3) . '_' . app()->getLocale();
        }

        switch ($val) {
            case 'site_name':
                $value = $this->siteSetting?->where('key', 'site_name_' . app()->getLocale())->first()?->value;
                break;
            case 'site_name_lower':
                $value = $this->siteSetting?->where('key', 'site_name_lower_' . app()->getLocale())->first()?->value;
                break;
            case 'logo':
                $value = $this->siteSetting?->where('key', 'logo_' . app()->getLocale())->first()?->value;
                break;
            case 'address':
                $value = $this->siteSetting?->where('key', 'address_' . app()->getLocale())->first()?->value;
                break;
            case 'address_ksa':
                $value = $this->siteSetting?->where('key', 'address_ksa_' . app()->getLocale())->first()?->value;
                break;
          
            case 'footer_description':
                $value = $this->siteSetting?->where('key', 'footer_description_' . app()->getLocale())->first()?->value;
                break;
      
            case 'show_slider':
                $value = $this->upperNotify
                    ?->where('key', 'show_slider')
                    ->first()?->value;
                break;
            case 'mobile_ksa':
                $value = $this->siteSetting
                    ?->where('key', 'mobile_ksa')
                    ->first()?->value;
                break;
            case 'show_about_us':
                $value = $this->upperNotify
                    ?->where('key', 'show_about_us')
                    ->first()?->value;
                break;
            case 'show_product':
                $value = $this->upperNotify
                    ?->where('key', 'show_product')
                    ->first()?->value;
                break;
            case 'show_category':
                $value = $this->upperNotify
                    ?->where('key', 'show_category')
                    ->first()?->value;
                break;
            case 'show_career':
                $value = $this->upperNotify
                    ?->where('key', 'show_career')
                    ->first()?->value;
                break;
         
            case 'openTime':
                $value = $this->siteSetting?->where('key', 'open_' . app()->getLocale())->first()?->value;
                break;
          
            default:
                if (substr($val, -3) == "_en" || substr($val, -2) ==  "_ar") {
                    $val = substr($val, 0, -3) . '_' . app()->getLocale();
                }
                $value = $this->siteSetting?->where('key', $val)->first()?->value;
        }
        return $value;
    }


    public function getColor($val)
    {
        return array_filter(json_decode($this->colorsSetting->where('key', $val)->first()?->value));
    }

    public function getInfo($val)
    {
        return $this->infoSetting?->where('key', $val)->first()?->value;
    }

    public function getUpperNotify($val)
    {
        return $this->upperNotify?->where('key', $val)->first()?->value;
    }

    // public function getCoupon($val)
    // {
    //     return $this->couponSetting?->where('key', $val)->first()?->value;
    // }
    public function getCoupon($val)
    {
        if ($val === 'welcome_coupon_id') {
            return $this->couponSetting?->where('key', 'welcome_coupon_id')->first()?->value;
        }
        return $this->couponSetting?->where('key', $val)->first()?->value;
    }

  public function getScript($val)
    {
        return ($this->scriptSetting?->where('key', $val)->first()?->value);
    }

    public function getMeta($val)
    {
        return $this->metaSetting?->where('key', $val)->first()?->value;
    }

    public function getView($val)
    {
        return $this->viewSetting?->where('key', $val)->first()?->value;
    }
    public function getHome($val)
    {
        return $this->home_setting?->where('key', $val)->first()?->value;
    }
}

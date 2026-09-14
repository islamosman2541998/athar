<?php

namespace App\Settings;

use App\Models\HomeSettingPage;

class HomeSettingSingleton
{
    private static $instance;

    private $settings;

    private function __construct()
    {
        // Prevent instantiation
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new HomeSettingSingleton();
            self::$instance->loadSettingDatabase();
        }
        return self::$instance;
    }



    private function loadSettingDatabase()
    {
        $this->settings = HomeSettingPage::with('trans')->get();
    }


    public function getItem($val)
    {
        return $this->settings->where('title_section', $val)->first();
    }



    public function getAll()
    {
        return $this->settings = HomeSettingPage::active()->get();
    }

}

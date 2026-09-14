<?php

namespace Database\Seeders;

use App\Models\Settings;
use App\Models\SettingsValues;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = Settings::query();
        $settingExist = (clone $settings)->where('key', 'site_setting')->get();
        if ($settingExist->first() == null) {
            $setting = Settings::create(['key' => 'site_setting']);
            foreach (config('translatable.locales') as $locale) {
                SettingsValues::create(['key' => 'site_name_' . $locale, 'setting_id' => $setting->id, 'value' => "Athar"]);
                SettingsValues::create(['key' => 'address_' . $locale, 'setting_id' => $setting->id, 'value' => "16 Mostafa El-Nahass Street - Eighth District - Nasr City"]);
                SettingsValues::create(['key' => 'open_' . $locale, 'setting_id' => $setting->id, 'value' => "Monday - Friday  9:00AM - 05:00PM"]);
            }
            SettingsValues::create(['key' => 'mobile', 'setting_id' => $setting->id, 'value' => "01011700000"]);
            SettingsValues::create(['key' => 'whatsapp', 'setting_id' => $setting->id, 'value' => "01011700000"]);
            SettingsValues::create(['key' => 'email', 'setting_id' => $setting->id, 'value' => "info@holol.com"]);
            SettingsValues::create(['key' => 'facebook', 'setting_id' => $setting->id, 'value' => "https://facebook.com"]);
            SettingsValues::create(['key' => 'instagram', 'setting_id' => $setting->id, 'value' => "https://instagram.com"]);
            SettingsValues::create(['key' => 'twitter', 'setting_id' => $setting->id, 'value' => "https://twitter.com"]);
            SettingsValues::create(['key' => 'linked_in', 'setting_id' => $setting->id, 'value' => "https://linkedin.com"]);
            SettingsValues::create(['key' => 'youtube', 'setting_id' => $setting->id, 'value' => "https://youtube.com"]);
            SettingsValues::create(['key' => 'snapchat', 'setting_id' => $setting->id, 'value' => "https://snapchat.com"]);
            SettingsValues::create(['key' => 'maps', 'setting_id' => $setting->id, 'value' => ""]);
            foreach (config('translatable.locales') as $locale) {
                SettingsValues::create(['key' => 'logo_' . $locale, 'setting_id' => $setting->id, 'type' => 1]);
            }
            SettingsValues::create(['key' => 'icon', 'type' => 1, 'setting_id' => $setting->id]);
            SettingsValues::create(['key' => 'pdf', 'type' => 6, 'setting_id' => $setting->id]);


            SettingsValues::create(['key' => 'services_paginate', 'type' => 5, 'setting_id' => $setting->id]);
            SettingsValues::create(['key' => 'blogs_paginate', 'type' => 5, 'setting_id' => $setting->id]);
            SettingsValues::create(['key' => 'offers_paginate', 'type' => 5, 'setting_id' => $setting->id]);
        }
        $settingExist = $settings->where('key', 'meta_setting')->get();
        if (count($settingExist) == 0) {
            $setting = Settings::create(['key' => 'meta_setting']);
            foreach (config('translatable.locales') as $locale) {
                SettingsValues::create(['key' => 'home_meta_title_' . $locale,  'setting_id' => $setting->id, 'type' => 0]);
                SettingsValues::create(['key' => 'home_meta_description_' . $locale,  'setting_id' => $setting->id, 'type' => 2]);
                SettingsValues::create(['key' => 'home_meta_key_' . $locale, 'setting_id' => $setting->id, 'type' => 4]);

                SettingsValues::create(['key' => 'services_meta_title_' . $locale,  'setting_id' => $setting->id, 'type' => 0]);
                SettingsValues::create(['key' => 'services_meta_description_' . $locale,  'setting_id' => $setting->id, 'type' => 2]);
                SettingsValues::create(['key' => 'services_meta_key_' . $locale, 'setting_id' => $setting->id, 'type' => 4]);


                SettingsValues::create(['key' => 'portfolio_meta_title_' . $locale,  'setting_id' => $setting->id, 'type' => 0]);
                SettingsValues::create(['key' => 'portfolio_meta_description_' . $locale,  'setting_id' => $setting->id, 'type' => 2]);
                SettingsValues::create(['key' => 'portfolio_meta_key_' . $locale, 'setting_id' => $setting->id, 'type' => 4]);

                SettingsValues::create(['key' => 'offers_meta_title_' . $locale,  'setting_id' => $setting->id, 'type' => 0]);
                SettingsValues::create(['key' => 'offers_meta_description_' . $locale,  'setting_id' => $setting->id, 'type' => 2]);
                SettingsValues::create(['key' => 'offers_meta_key_' . $locale, 'setting_id' => $setting->id, 'type' => 4]);

                SettingsValues::create(['key' => 'blogs_meta_title_' . $locale,  'setting_id' => $setting->id, 'type' => 0]);
                SettingsValues::create(['key' => 'blogs_meta_description_' . $locale,  'setting_id' => $setting->id, 'type' => 2]);
                SettingsValues::create(['key' => 'blogs_meta_key_' . $locale, 'setting_id' => $setting->id, 'type' => 4]);

                SettingsValues::create(['key' => 'contact_meta_title_' . $locale,  'setting_id' => $setting->id, 'type' => 0]);
                SettingsValues::create(['key' => 'contact_meta_description_' . $locale,  'setting_id' => $setting->id, 'type' => 2]);
                SettingsValues::create(['key' => 'contact_meta_key_' . $locale, 'setting_id' => $setting->id, 'type' => 4]);
            }
        }
    }
}

<?php

use App\Models\Pages;
use App\Models\Settings;


if (!function_exists('SETTING_SITE')) {
    function SETTING_SITE($key = false){
        $setting = @Settings::query()->where('key', 'site_setting')->get()->first();
        if($setting != null){
            return  @$setting->values->where('key', $key)->first()->value;
        }
        else return "";
    }
}


if (!function_exists('MULTIPLE_SETTING_SITE')) {
    function MULTIPLE_SETTING_SITE($arr_key = false){
        $setting = @Settings::query()->where('key', 'site_setting')->get()->first();
        if($setting != null){
            return  @$setting->values->whereIn('key', $arr_key)->pluck('value' , 'key' );
        }
        else return "";
    }
}



if (!function_exists('getPages')) {
    function getPages($id = null) {
        if($id == ''){
            $pages = @Pages::query()->with('trans')->where('id','>',1)->Active()->get();
        }
        else{
            $pages = @Pages::query()->with('trans')->whereId($id)->first();
        }
        return $pages ;
    }
}

if (!function_exists('media_asset')) {
    /**
     * Asset URL that prefers an existing .webp sibling (created by `php artisan images:webp`).
     * Falls back to the original file when no WebP version exists.
     */
    function media_asset(?string $path, ?string $fallback = null): string
    {
        $path = ltrim((string) ($path ?: $fallback), '/');

        if ($path !== '' && preg_match('/\.(jpe?g|png)$/i', $path)) {
            $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);
            if (is_file(public_path($webp))) {
                return asset($webp);
            }
        }

        return asset($path);
    }
}

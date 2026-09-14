<?php

namespace App\Traits\Api;


trait  MetaSettingTrait
{

    public function getMetaDetails($pageName)
    {

        $data['title'] = \App\Settings\SettingSingleton::getInstance()->getMeta($pageName . '_meta_title_' . app()->getLocale());
        $data['key'] = \App\Settings\SettingSingleton::getInstance()->getMeta($pageName . '_meta_key_' . app()->getLocale());
        $data['description'] = \App\Settings\SettingSingleton::getInstance()->getMeta($pageName . '_meta_description_' . app()->getLocale());


        return $data;
    }
}

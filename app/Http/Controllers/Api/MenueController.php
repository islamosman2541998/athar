<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenueResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SiteSettingResource;
use App\Models\Menue;
use App\Settings\SettingSingleton;
use Illuminate\Http\Request;

class MenueController extends Controller
{
    public function index()
    {

        $query = Menue::with('trans', 'children')->active()->parent()->orderBy('sort' ,'ASC');
        $menu = (clone $query)->main()->get();

        $footer = $query->footer()->get();

        $data =  [
            'main' => MenueResource::collection($menu),
            'footer' => MenueResource::collection($footer),
            'cart_num' => 0, // will modify
            'site_setting' => SiteSettingResource::collection(SettingSingleton::getInstance()->getSiteSetting()),
        ];

        return $this->success($data, null, 200);


    }
}

<?php

namespace App\Http\Controllers\Api\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupGalleryResource;
use App\Http\Resources\HomePageSettingResource;
use App\Http\Resources\HomeSettingResource;
use App\Http\Resources\MetaSettingResource;
use App\Http\Resources\ServiceCategoryForHomePageResource;
use App\Http\Resources\ServiceCategoryResource;
use App\Http\Resources\SingleGalleryResource;
use App\Http\Resources\SliderResource;
use App\Models\Gallery;
use App\Models\GalleryGroup;
use App\Models\Order;
use App\Models\Product;
use App\Models\ServiceCategory;
use App\Models\Slider;
use App\Models\WhatsAppContact;
use App\Settings\HomeSettingSingleton;
use App\Settings\SettingSingleton;
use App\Traits\Api\MetaSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class MainPageController extends Controller
{
    use MetaSettingTrait;


    public function index()
    {
        $data = [];
        $items = [];
        $home = HomeSettingSingleton::getInstance();
        $groupGallery = GalleryGroup::with(['images' => function ($q) {
            $q->orderBy('sort', 'asc');
        }])->where('type', '==', (int)4)->latest()->first();
        foreach ($home->getAll() as $item) {
            if ($item == null) {
                continue;
            }
            $items[] = new HomePageSettingResource($item);
        }
        $data['items_of_home_settings'] = $items;
        $data['sliders'] = SliderResource::collection(Slider::orderBy('sort', 'ASC')->active()->get());
        $data['services'] = ServiceCategoryForHomePageResource::collection(ServiceCategory::orderBy('sort', 'ASC')->active()->feature()->get());
        $data['meta_info'] = [$this->getMetaDetails('home')];
        //        $data ['gallery']= [ new GroupGalleryResource( GalleryGroup::with('images')->where('type' , 4 )->first())];
        $data['gallery'] = $groupGallery && $groupGallery->images ? SingleGalleryResource::collection($groupGallery->images) : [];

        return $this->success($data, null, 200);
    }


    public function show(Request $request)
    {

        /********************rate part*****************/
        $data['order_to_rate'] = [];
        if ($request->order_cookie) {
            $order = Order::with('orderDetails.product')->where('unique_order_cookies', $request->order_cookie)->delivered()->notrated()->latest()->first();

            if ($order) {
                $data['order_to_rate']['order_id'] = $order->id;
                $products = Product::with('transNow:id,title')->whereIn('id', $order->orderDetails->pluck('product_id')->toArray())->select('id', 'image')->get();

                foreach ($products as $key => $val) {
                    $data['order_to_rate']['product'][$key]['id'] = $val->id;
                    $data['order_to_rate']['product'][$key]['title'] = $val->transNow ?->title;
                    $data['order_to_rate']['product'][$key]['image'] = url($val->PathInView());


               }

            }
        }
        /********************rate part*****************/


        $homeSetting = HomeSettingSingleton::getInstance();
        $groupGallery = GalleryGroup::with(['images' => function ($q) {
            $q->orderBy('sort', 'asc');
        }])->where('type', 4)->latest()->first();

        $data['meta'] = $this->getMetaDetails('home');
        $data['sliders'] = SliderResource::collection(Slider::orderBy('sort', 'ASC')->active()->get());
        $data['about_us'] = new HomeSettingResource($homeSetting->getItem('home'));
        $data['service'] = [
            'info' => new HomeSettingResource($homeSetting->getItem('services')),
            'items' => ServiceCategoryForHomePageResource::collection(ServiceCategory::orderBy('sort', 'ASC')->active()->feature()->get()),
            'services_shop_image' => asset($homeSetting->getItem('services_shop_image')->pathInView()) ,
            'services_landscape_image' =>  asset($homeSetting->getItem('services_landscape_image')->pathInView()),
            'services_events_image' => asset($homeSetting->getItem('services_events_image')->pathInView()),
        ];
        $data['mission'] = new HomeSettingResource($homeSetting->getItem('mission'));

        $data['local_florist_just_for_you'] = [
           'section' => new HomeSettingResource($homeSetting->getItem('local_florist_just_for_you')),
            'left_image' => asset($homeSetting->getItem('left_image')?->image),
            'right_image' => asset($homeSetting->getItem('right_image')?->image),
        ];


        $data['tabs'] = [
            new HomeSettingResource($homeSetting->getItem('happiness')),
            new HomeSettingResource($homeSetting->getItem('organic')),
            new HomeSettingResource($homeSetting->getItem('freshness')),
            new HomeSettingResource($homeSetting->getItem('delivery')),
        ];
        $data['portfolio'] = [
            'info' => new HomeSettingResource($homeSetting->getItem('our_portfolio')),
            'items' => isset($groupGallery) && $groupGallery->images ? SingleGalleryResource::collection(@$groupGallery->images) : [],
        ];
        $data['makers'] = new HomeSettingResource($homeSetting->getItem('makers'));
        $data['contact_us'] = new HomeSettingResource($homeSetting->getItem('contact-us'));

        $data['social_links'] = MULTIPLE_SETTING_SITE(['facebook', 'instagram', 'tiktok']);
        $data['contact_info'] = MULTIPLE_SETTING_SITE(['email', 'mobile']);
        $data['contact_info']['address'] = SettingSingleton::getInstance()->getItem('address');

        return $this->success($data, null, 200);
    }

}

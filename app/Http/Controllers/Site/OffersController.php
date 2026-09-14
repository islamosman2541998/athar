<?php

namespace App\Http\Controllers\Site;

use App\Models\News;
use App\Http\Controllers\Controller;
use App\Settings\HomeSettingSingleton;

class OffersController extends Controller
{

    public function index()
    {
        $offers = News::query()->with('trans')->active()->orderBy('sort', 'ASC')->limit(6)->get();

        $offersInfo = HomeSettingSingleton::getInstance()->getItem('offers');
        
        return view('site.pages.offers.index',compact('offers', 'offersInfo'));
    }


    public function show($slug)
    {
        if(is_numeric($slug)){
            $offer = News::findOrFail($slug);
        }
        else{
            $offer = News::with('trans')->WhereTranslation('slug', $slug)->get()->first();
            if($offer == null) abort('404');
        }

        return view('site.pages.offers.show',compact('offer'));
    }
}

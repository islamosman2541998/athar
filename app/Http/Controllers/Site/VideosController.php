<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Settings\HomeSettingSingleton;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function index()
    {
        $videos = Video::query()->with('trans')->active()->orderBy('sort', 'ASC')->limit(4)->get();

        $videoInfo = HomeSettingSingleton::getInstance()->getItem('videos');

        return view('site.pages.videos.index',compact('videos', 'videoInfo'));
    }


    public function show($slug)
    {

        if(is_numeric($slug)){
            $video = Video::findOrFail($slug);
        }
        else{
            $video = Video::with('trans')->WhereTranslation('slug', $slug)->get()->first();
            if($video == null) abort('404');
        }

        return view('site.pages.videos.show',compact('video'));
    }
}

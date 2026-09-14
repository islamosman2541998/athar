<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

use App\Settings\HomeSettingSingleton;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::query()->with('trans')->active()->orderBy('sort', 'ASC')->limit(6)->get();
        $galleryInfo = HomeSettingSingleton::getInstance()->getItem('gallery');
        $current_lang = app()->getLocale();

        if ($galleryInfo) {
            $galleryInfo->load('trans');
        }

        return view('site.pages.gallery.index', compact('galleries', 'galleryInfo', 'current_lang'));
    }

    public function show($slug)
    {
        if (is_numeric($slug)) {
            $gallery = Gallery::findOrFail($slug);
        } else {
            $gallery = Gallery::with('trans')->whereTranslation('slug', $slug)->get()->first();
            if ($gallery == null) abort('404');
        }

        $current_lang = app()->getLocale();
        return view('site.pages.gallery.show', compact('gallery', 'current_lang'));
    }
}

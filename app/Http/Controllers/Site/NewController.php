<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\News;
use Illuminate\Http\Request;

class NewController extends Controller
{
   
    public function index()
    {
        $news = News::with('transNow')->where('status', 1)
            ->get();
        $first_news = $news->first();

        return view('site.pages.news.index', compact('news', 'first_news'));
    }

  
   public function show(News $news)
    {
       
        abort_unless((int) $news->status === 1, 404);
        $news->load('transNow');

        return view('site.pages.news.show', compact('news'));
    }
   public function maya( )
    {
       

        return view('site.pages.maya');
    }
}

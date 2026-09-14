<?php

namespace App\Http\Controllers\Site;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {

        $about = About::with('translations')->first();

        return view('site.pages.about.index', compact('about'));
    }
}

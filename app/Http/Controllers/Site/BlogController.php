<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     */
    public function index()
    {
        $blogs = Blog::with('transNow')->active()->orderBy('sort', 'ASC')->get();

        return view('site.pages.blogs.index', compact('blogs'));
    }

    /**
     */
    public function show(Blog $blog)
    {
        abort_unless((int) $blog->status === 1, 404);
        $blog->load('transNow');
        return view('site.pages.blogs.show', compact('blog'));
    }
}

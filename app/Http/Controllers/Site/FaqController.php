<?php

namespace App\Http\Controllers\Site;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::with(['transNow', 'faqs' => fn ($query) => $query->active()->with('transNow')->orderBy('sort')])->where('status', 1)->orderBy('sort')->get();

        return view('site.pages.faq-questions.index', compact('categories'));
    }
}

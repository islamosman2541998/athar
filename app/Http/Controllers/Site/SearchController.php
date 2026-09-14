<?php

namespace App\Http\Controllers\Site;

use App\Models\Product;
use App\Models\Occasion;
use App\Models\ProductCategory;
use App\Models\Filter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index()
    {
        return view('site.pages.search.index');
    }

public function results(Request $request)
{
    $request->validate(['query' => 'required|string|max:255']);
    $q = "{$request->query('query')}";

    $categories = ProductCategory::active()
        ->whereTranslationLike('title', $q)
        ->get()
        ->each(fn($m) => $m->setAttribute('search_type','category'));

    $occasions = Occasion::active()
        ->whereTranslationLike('title', $q)
        ->get()
        ->each(fn($m) => $m->setAttribute('search_type','occasion'));

    $filterIds = Filter::whereTranslationLike('name', $q)
        ->pluck('id'); 

    $directProducts = Product::active()
        ->where(function($qb) use ($q) {
            $qb->whereTranslationLike('title', $q)
               ->orWhereTranslationLike('description', $q);
        });

    if ($filterIds->isNotEmpty()) {
        $directProducts = $directProducts->orWhereHas('filters', function($qb) use ($filterIds) {
            $qb->whereIn('filters.id', $filterIds);
        });
    }

    $products = $directProducts
        ->get()
        ->each(fn($m) => $m->setAttribute('search_type','product'));

    $results = $categories
        ->merge($occasions)
        ->merge($products)
        ->sortByDesc(fn($m) => $m->created_at ?? now())
        ->values();

    return view('site.pages.search.results', compact('q','results'));
}

}
<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('transNow')->active()->orderBy('sort','ASC')->get();        
        return view('site.pages.categories.index', compact('categories'));
    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $category = ProductCategory::with(['transNow', 'products'])->findOrFail($id);
        } else {
            $category = ProductCategory::with(['transNow', 'products'])->WhereTranslation('slug', $id)->get()->first();
            if ($category == null) abort('404');
        }

        return view('site.pages.categories.show', compact('category'));
    }

}

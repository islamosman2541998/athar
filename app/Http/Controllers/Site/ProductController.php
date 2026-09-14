<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('transNow', 'products')->active()->orderBy('sort','ASC')->get();
        return view('site.pages.products.index', compact('categories'));
    }

    public function mostSelling()
    {
        $mostSellingProducts = Product::active()
            ->with(['transNow', 'rates', 'orderDetails'])
            ->withCount(['orderDetails as total_sold' => function ($query) {
                $query->select(DB::raw('SUM(quantity)'));
            }])
            ->orderByDesc('total_sold')
            ->where('show_in_cart', 0)
            ->get();

        return view('components.mostselling', compact('mostSellingProducts'));
    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $product = Product::with(['transNow', 'pockets.translations', 'galleryGroup.images', 'paymentLine', 'tips', 'info'])->findOrFail($id);
        } else {
            $product = Product::with(['transNow', 'pockets.translations', 'galleryGroup.images', 'paymentLine', 'tips', 'info'])
            ->whereHas('trans', function ($q) use ($id) {
                $q->where('slug', $id);
            })
            ->first();
            if ($product == null) abort('404');
        }

        return view('site.pages.products.show', compact('product'));
    }
}

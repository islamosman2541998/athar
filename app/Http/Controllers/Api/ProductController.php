<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function League\Flysystem\map;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with('trans', 'galleryGroup.images')->withAvg('rates', 'rating_value')->ordinary()->feature()->active()->orderBy('sort', 'ASC');


        // filters by cats
        if (isset($request->categories)) {
            $cats = json_decode($request->input('categories'), true) ?? [];
            $query = $query->whereHas('productCategoriesProducts', function ($q) use ($cats) {
                $q->whereIn('product_categories.id', $cats ?? []);
            });
        }


        // filters by Occasions
        if (isset($request->occasions)) {
            $occasions = json_decode($request->input('occasions'), true) ?? [];
            $query = $query->whereHas('occasions', function ($q) use ($occasions) {
                $q->whereIn('occassions.id', $occasions ?? []);
            });
        }

        // filter by price
        if (isset($request->to_price)) {
            $query = $query->where('price_after_sale', '<=', $request->to_price);
        }
        if (isset($request->from_price)) {
            $query = $query->where('price_after_sale', '>=', $request->from_price);
        }

        // sort
        if (isset($request->sort)) {
            if ($request->sort == "low_price") $query = $query->orderBy('price_after_sale', 'ASC');
            if ($request->sort == "high_price") $query = $query->orderBy('price_after_sale', 'DESC');
            if ($request->sort == "newest") $query = $query->orderBy('created_at', 'DESC');
        } else {
            $query = $query->orderBy('sort', 'ASC');
        }

        $items = $query->paginate($this->site_pagination_count);

        return $this->success(new PaginateResource(ProductResource::collection($items)), "", 200);
    }


    /*# show product  ##*/
    /*
    * show product with its related category and its multiple occasions  with their translations
    */
//    public function show($id)
//    {
//        if (is_numeric($id)) {
//            $items = Product::with('trans', 'galleryGroup.images', 'occasions', 'productCategoriesProducts')->find($id);
//        } else {
//            $items = Product::with('trans', 'galleryGroup.images', 'occasions', 'productCategoriesProducts')->WhereTranslation('slug', $id)->get()->first();
//        }
//
//        if ($items == null) return $this->notFoundResponse();
//        $ids = optional($items->productCategoriesProducts)->pluck('id')->toArray();
//
//        $relatedProducts = DB::table('product_category_products')->join('products', 'product_category_products.product_id', '=', 'products.id')
//            ->join('product_categories', 'product_category_products.product_category_id', 'product_categories.id')
//            ->join('product_translations', 'product_translations.product_id', '=', 'products.id')
//            ->whereIn('product_categories.id', $ids)
//            ->where('product_translations.locale', '=', app()->getLocale())
//            ->select('products.id', 'product_translations.title', 'product_translations.description', 'products.image')->limit(3)->get()->toArray();
//
//        $pageResource = new ProductResource($items);
//        $pageResource->setReloadMeta(true);
//        /*******************************************************************************************/
//        array_push($relatedProducts, ['image_path_of_related_products' => url( Product::staticPath()) . "/"]);
//        $data = ['product' => $pageResource, 'related_products' => $relatedProducts];
//        /*******************************************************************************************/
//
//
//        return $this->success($data, null, 200);
//    }
//DB::raw("CONCAT('images/', image) AS image_path")

    public function show($id)
    {
        if (is_numeric($id)) {
            $items = Product::with('trans', 'galleryGroup.images', 'occasions', 'productCategoriesProducts')->find($id);
        } else {
            $items = Product::with('trans', 'galleryGroup.images', 'occasions', 'productCategoriesProducts')->WhereTranslation('slug', $id)->get()->first();
        }

        if ($items == null) return $this->notFoundResponse();
        $ids = optional($items->productCategoriesProducts)->pluck('id')->toArray();

        $relatedProducts = DB::table('product_category_products')->join('products', 'product_category_products.product_id', '=', 'products.id')
            ->join('product_categories', 'product_category_products.product_category_id', 'product_categories.id')
            ->join('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->whereIn('product_categories.id', $ids)
            ->where('product_translations.locale', '=', app()->getLocale())
            ->select('products.id',
                'product_translations.title',
                'product_translations.slug',

                'product_translations.description',
                DB::raw("CONCAT('" . url(Product::staticPath()) . "/', products.image) AS image"),
                'products.price', 'products.price_after_sale',
                'products.sale',
                'code',
                'in_stock')->limit(3)->get()->toArray();


        $pageResource = new ProductResource($items);
        $pageResource->setReloadMeta(true);
        /*******************************************************************************************/
        $data = ['product' => $pageResource, 'related_products' => $relatedProducts];
        /*******************************************************************************************/


        return $this->success($data, null, 200);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use App\Models\ProductCategoryTranslation;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $items = ProductCategory::query()->withCount(['productCategoriesProducts' => function ($q){
            $q->where('status' , 1)->where('feature' , 1)->where('show_in_cart' , '!=' ,1)->orderBy('sort', 'ASC');
        }])->ordinary()->active()->feature()->orderBy('sort', 'ASC')->get();
        return $this->success(ProductCategoryResource::collection($items), null, 200);
    }

    public function show($id)
    {
        if(is_numeric($id)){
            $items = ProductCategory::with('trans', 'galleryGroup.images', 'productCategoriesProducts')->find($id);
        }
        else{
            $items = ProductCategory::with('trans', 'galleryGroup.images', 'productCategoriesProducts')->WhereTranslation('slug', $id)->get()->first();
        }

        if($items == null) return $this->notFoundResponse();

        return $this->success(new ProductCategoryResource($items), null, 200);

    }


}

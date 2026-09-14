<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function Spatie\Ignition\viewPath;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? '',
            'title' => $this->transNow->title ?? '',
            'slug' => $this->transNow->slug ?? '',
            'description' => $this->transNow->description ?? '',
            'image' => asset($this->pathInView()),
            'count_of_products' => $this->product_categories_products_count??0,

            'gallery' => new GroupGalleryResource($this->whenLoaded('galleryGroup' )),

            'products' => $this->whenLoaded('productCategoriesProducts', function ()  {
                   return ProductResource::collection($this->productCategoriesProducts);
            }),


        ];
    }
}

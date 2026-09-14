<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OccasionResource extends JsonResource
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
            'description' => $this->transNow->description ?? '',
            'image' => asset($this->pathInView()),
            'count_of_products' => $this->products_count??0,

            'products' => $this->whenLoaded('products', function () {
                return ProductResource::collection($this->products);
            }),

            'galleries' => $this->whenLoaded('galleryGroup', function () {
                $galleries =     $this->galleryGroup  ?      GroupGalleryResource::collection($this->galleryGroup) : [];
                return $galleries;
            }),


        ];
    }
}

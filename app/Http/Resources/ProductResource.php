<?php

namespace App\Http\Resources;

use App\Models\Menue;
use App\Settings\SettingSingleton;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    protected $reloadMeta = false;

    public function setReloadMeta($reload)
    {
        $this->reloadMeta = $reload;
    }

    public function toArray($request)
    {
          $meta = [];
        if ($this->reloadMeta) {
            $meta = [
                'title' => $this->transNow->meta_title,
                'key' => $this->transNow->meta_key,
                'description' => $this->transNow->meta_description,
            ];
        }
        return [
            'meta' => $meta == [] ? null : $meta,
            'id' => $this->id ?? '',
            'title' => $this->transNow->title ?? '',
            'slug' => $this->transNow->slug ?? '',
            'description' => $this->transNow->description ?? '',
            'image' => asset($this->pathInView()),
            'price' => $this->price,
            'price_after_sale' => $this->price_after_sale,
            'sale' => $this->sale,
            'code' => $this->code,
            'in_stock' => $this->in_stock,
            'average_rate' => $this->rates_avg_rating_value??0,
            'gallery' => new GroupGalleryResource($this->whenLoaded('galleryGroup')),



            'category' => $this->whenLoaded('productCategoriesProducts', function () {
                $arr = [];
                foreach ($this->productCategoriesProducts ?? [] as $key => $val) {
                    $arr[] = $val->transNow->title;
                }
                return $arr;
            }),


            'occasions' => $this->whenLoaded('occasions', function () {
                $arr = [];
                    foreach ($this->occasions ?? [] as $key => $val) {
                        $arr[] = $val->transNow->title;
                    }
                return $arr;
            }),
        ];
    }
}

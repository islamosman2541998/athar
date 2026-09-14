<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function League\Flysystem\get;

class GroupGalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        //        return parent::toArray($request);
        return [
//            'id' => $this->id ?? '',

            'gallery_title' => $this->transNow->title ?? '',


//            'gallery_images_all' => $this->images ?? '',
            'gallery_images' => $this->whenLoaded('images', function () {
                $all_products = [];
//


                foreach ($this->images as $key => $val) {
//                        $all_products[$key]['image'] = $val->image ?? '';
//                    $all_products[$key]['sort'] = $val->sort ?? '';
                    $all_products[$key]['image'] = $this->type > -1 ? asset($val->pathInView(['products', 'product_category', 'service_category', 'occasions' , 'main_page'][$this->type])) : '';
                }

                return $all_products;
            })

        ];

    }
}

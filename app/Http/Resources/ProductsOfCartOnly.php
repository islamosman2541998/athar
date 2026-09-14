<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsOfCartOnly extends JsonResource
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
            'image' => asset($this->pathInView()),
            'price' => $this->price,
            'price_after_sale' => $this->price_after_sale,
            'sale' => $this->sale,
            'in_stock' => $this->in_stock,
        ];
    }
}

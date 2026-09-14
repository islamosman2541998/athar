<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        'user_id',
//        'product_id',
//        'product_name',
//        'cookeries',
//        'price',
//        'total_price',
//        'quantity',
//        'total',
//        'cart_group_id',

        return [
            'id' => $this->id ?? '',
            'product_name' => $this->product_name ?? '',
            'cookeries' => $this->cookeries ?? '',
            'price' => $this->price ?? '',
            'total' => $this->total ?? '',
            'quantity' => $this->quantity ?? '',
            'product_image' => $this->whenLoaded('product', function ()  {
                return asset($this?->product?->pathInView('image'));

//                return ProductResource::collection($this->product);
            }),


        ];
    }
}

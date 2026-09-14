<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\HttpKernel\Debug\pop;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image =['payment_method_image' => ( $this->image ? asset( $this->pathInView()) : null)];
       $all = array_merge(            parent::toArray($request), $image);
        return [
            $all
//            'order' => parent::toArray($request),
//            'orderDetails' => $this->whenLoaded('orderDetails', function () {
//                return $this->orderDetails;
//            }),


        ];

    }
}

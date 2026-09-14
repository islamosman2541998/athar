<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'customer_name' => $this->customer_name,
            'description' => $this->description,
//            'rate' => $this->rate,
//            'status' => $this->status,
//            'reviewable_type' => $this->reviewable_type ,
//            'reviewable_id' => $this->reviewable_id ,
            'image' => asset($this->pathInView()),


        ];
    }
}

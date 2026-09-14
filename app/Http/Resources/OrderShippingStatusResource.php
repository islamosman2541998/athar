<?php

namespace App\Http\Resources;

use App\Enums\ShippingEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderShippingStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
                'shipping_status' => __( 'admin.'. $this->shipped_status),
                'date' => $this->created_at,
                'order' => $this->whenLoaded($this->order),
            ];
    }
}

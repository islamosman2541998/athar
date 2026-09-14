<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'unique_name' => $this->unique_name,
            'logo' => $this->logo ?  url($this->path() . $this->logo) : '',
            'minimum_price' => $this->minimum_price,
            'other_info' => [
                'qr_image' => $this->qr_image ? url($this->path() . $this->qr_image) : '',
                'number' => $this->number,
                'user_name' => $this->user_name,
                'description' => $this->description],
        ];
    }
}

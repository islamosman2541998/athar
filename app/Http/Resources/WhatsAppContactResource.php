<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WhatsAppContactResource extends JsonResource
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
            'title' => $this->transNow ?->title,
            'image' => url($this->pathInView()),
            'number' => $this->number,
        ];
    }
}

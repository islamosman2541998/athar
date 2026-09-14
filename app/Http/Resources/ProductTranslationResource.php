<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTranslationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'locale' => $this->locale,
            'title' => $this->title,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'meta_desc' => $this->meta_desc,
            'meta_key' => $this->meta_key,







        ];
    }
}

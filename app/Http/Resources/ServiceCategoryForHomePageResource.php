<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryForHomePageResource extends JsonResource
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
            'slug' => $this->transNow->slug ?? '',
            'title' => $this->transNow->title ?? '',
//            'image' => asset($this->pathInView()),


        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'meta' =>[
                'title' => $this->transNow->meta_title,
                'key' => $this->transNow->meta_key,
                'description' => $this->transNow->meta_description,
            ],

            'title' => $this->transNow->title ?? '',
            'description' => $this->transNow->content ?? '',
            'image' => asset($this->pathInView()),
        ];
    }
}

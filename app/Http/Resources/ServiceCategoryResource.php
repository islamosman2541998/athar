<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $images = [];


        return [
            'meta' => [
                'meta_title' => $this->transNow->meta_title ?? '',
                'meta_desc' => $this->transNow->meta_desc ?? '',
                'meta_key' => $this->transNow->meta_key ?? '',
            ],

            'title' => $this->transNow->title ?? '',
            'slug' => $this->transNow->slug ?? '',
            'description' => $this->transNow->description ?? '',

            'middle_title' => $this->transNow->middle_title ?? '',
            'middle_content' => $this->transNow->middle_content ?? '',

            'image' => asset($this->pathInView()),

            'occasions' => $this->whenLoaded('occasions', function () {
                return EventOcassionResource::collection($this->occasions);
            }),



        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomePageSettingResource extends JsonResource
{
//{{dd(\App\Settings\SettingSingleton::getInstance()->getMeta('home_meta_description_en'))}}

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [$this->title_section => [

            'title' => $this->translate(app()->getLocale())->title,
            'sub_title' => $this->translate(app()->getLocale())->sub_title,
            'description' => $this->translate(app()->getLocale())->description,
            'image' => asset($this->pathInView()),
            'url' => $this->url,


            'children' => $this->whenLoaded('children', function () {
                return MenueResource::collection($this->children);
            }),


        ]];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'title' => $this->translate(app()->getLocale())->title,
            'sub_title' => $this->translate(app()->getLocale())->sub_title,
            'description' => removeHTML($this->translate(app()->getLocale())->description),
            'image' => asset($this->pathInView()),

        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Settings\SettingSingleton;

class MenueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'url' =>  $this->type == 'static'? $this->url : $this->dynamic_url,

            'children' => $this->whenLoaded('children' , function (){
                return  MenueResource::collection( $this->children);
            }),
         ];
    }
}

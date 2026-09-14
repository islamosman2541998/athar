<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleGalleryResource extends JsonResource
{
    protected  $type;
    public function __construct($resource , $type = null)
    {
        parent::__construct($resource);
        $this->type = $type;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($reques )
    {

        if($this->type == "landscape" || $this->type == "repair"){
            return [
                'image' => asset($this->pathInView('service_category')),
            ];
        }
        return [
            'image' => asset($this->pathInView('main_page')),
        ];

    }
}

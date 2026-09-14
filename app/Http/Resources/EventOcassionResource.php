<?php

namespace App\Http\Resources;

use App\Models\Gallery;
use Illuminate\Http\Resources\Json\JsonResource;

class EventOcassionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $galleriesID = $this->galleryGroup->pluck('id')->toArray();

        $array = Gallery::whereIn('gallery_group_id', $galleriesID)->get()->pluck('image')->toArray();
        $stringToAdd = "/attachments/gallery/occasions/";

        $newArray = array_map(function ($value) use ($stringToAdd) {
            return asset($stringToAdd . $value) ;
        }, $array);

        return [
            'title' => $this->title,
            'gallery' => $newArray,
        ];
    }
}

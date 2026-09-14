<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
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
            'items' => $this->resource,

            'pagination' => [
                'total_items' => $this->resource->total(),
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
                'total_pages' => $this->resource->lastPage(),
                'next_page' => $this->resource->nextPageUrl(),
                'prev_page_url' => $this->resource->previousPageUrl(),
                'first_page_url' => $this->resource->url(1),
                'last_page_url' => $this->resource->url($this->resource->lastPage()),

            ],
        ];
    }
}

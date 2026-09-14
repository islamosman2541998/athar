<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCategoryResource;
use App\Http\Resources\SingleGalleryResource;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show($id)
    {

        if (is_numeric($id)) {
            $items = ServiceCategory::with('galleryGroup.images')->find($id);
        } else {
            $items = ServiceCategory::with('galleryGroup.images')->WhereTranslation('slug', $id)->get()->first();
        }

//        if ($items->service_unique_name === "events") {
//            $items->with('galleryGroup.images', 'occasions.galleryGroup.images')->where('service_unique_name', 'events')->firstOrFail();
//            if ($items == null) return $this->notFoundResponse();
//
//            return $this->success(new ServiceCategoryResource($items),
//                null, 200);
//
//        }


        if ($items == null) return $this->notFoundResponse();

        $type = $items->service_unique_name;

        return $this->success(['service' => new ServiceCategoryResource($items),
            'gallery' => SingleGalleryResource::collection($items->galleryGroup->images->map(function ($image) use ($type) {
                return new SingleGalleryResource($image, $type);
            }))],
            null, 200);

    }


    public function showEventsService()
    {
        $items = ServiceCategory::with('galleryGroup.images', 'occasions.galleryGroup.images')->where('service_unique_name', 'events')->firstOrFail();
        if ($items == null) return $this->notFoundResponse();

        return $this->success(new ServiceCategoryResource($items),
            null, 200);
    }

}

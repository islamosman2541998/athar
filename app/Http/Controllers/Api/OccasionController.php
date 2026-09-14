<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OccasionResource;
use App\Models\Occasion;
use Illuminate\Http\Request;

class OccasionController extends Controller
{

    public function index()
    {
        $items = Occasion::where('type' , 0)->with('galleryGroup.images')->withCount(['products' => function ($q){
            $q->where('status' , 1)->where('feature' , 1)->where('show_in_cart' , 0)->orderBy('sort', 'ASC');

        }])->active()->feature()->orderBy('sort' , 'ASC')->get();

        return $this->success(OccasionResource::collection($items), null, 200);
    }

    public function show($id)
    {

        if(is_numeric($id)){
            $items = Occasion::where('type' , 0)->with('trans', 'galleryGroup.images', 'products')->find($id);
        }
        else{
            $items = Occasion::where('type' , 0)->with('trans', 'galleryGroup.images', 'products')->WhereTranslation('slug', $id)->first();
        }
        if($items == null) return $this->notFoundResponse();


        return $this->success(new OccasionResource($items), null, 200);
    }

}

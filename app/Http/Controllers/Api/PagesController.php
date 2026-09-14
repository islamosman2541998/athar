<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Pages;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function show(Request $request)
    {   
        $slug =  $request->slug;
        if(is_numeric($slug)){
            $page = Pages::find($slug);
        }
        else{
            $page = Pages::with('trans')->WhereTranslation('slug', $slug)->get()->first();
        }

        if($page == null){ return $this->notFoundResponse(trans("pages.notfound")); }
        
        return $this->success(new PageResource($page), "", 200);
    }
}

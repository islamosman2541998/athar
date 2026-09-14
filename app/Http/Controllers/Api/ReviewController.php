<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use App\Traits\Api\ApiResponseTrait;
use App\Traits\FileHandler;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponseTrait;
    use FileHandler;
    protected $review_path;




    public function __construct()
    {
        $this->review_path = '/attachments/reviews/';
    }


    public function index(Request $request)
    {
        $reviews = Review::where(['reviewable_type' => null,
            'reviewable_id' => null])->active()->feature()->get();
        if($reviews->count() < 1){
            return $this->notFoundResponse();
        }
        return $this->success(ReviewResource::collection($reviews), '', 201);
    }


//    public function index(Request $request)
//    {
//        $reviews = Review::where(['reviewable_type' => "App\Models\Product",
//            'reviewable_id' => $request->product_id])->get();
//        if($reviews->count() < 1){
//            return $this->notFoundResponse();
//        }
//        return $this->success(ReviewResource::collection($reviews), '', 201);
//    }



// of morph many
//    public function store(ReviewRequest $request)
//    {
//        $request->validated();
//        $product = Product::find($request->product_id);
//        if (!$product) {
//            return $this->notFoundResponse();
//        }
//        $old_review = $product->reviews;
//        if ($old_review && $old_review->count()) {
//            return $this->notFoundResponse('Review is already exist');
//        }
//
//        $review = new Review([
//            'customer_name' => $request->customer_name,
//            'description' => $request->description,
//            'rate' => $request->rate,
//            'status' => 0,
//        ]);
//        if ($request->image) {
//            $image = $this->storeImage2($request, $this->review_path, $request->image, 'image');
//            $review->image = $image;
//        }
//
//        $product->reviews()->save($review);
//        return $this->success([], __('admin.review is adedd successfully'), 201);
//
//
//    }

    public function store(ReviewRequest $request)
    {
        $request->validated();

        $review =   Review::create([
            'customer_name' => $request->customer_name,
            'description' => $request->description,
            'status' => 0,
        ]);
        if ($request->image) {
            $image = $this->storeImage2($request, $this->review_path, $request->image, 'image');
            $review->image = $image;
            $review->save();
        }

        return $this->success([], __('admin.review is adedd successfully'), 201);


    }

}

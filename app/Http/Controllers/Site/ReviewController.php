<?php

namespace App\Http\Controllers\Site;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{


   public function store(Request $request, Product $product)
{

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'rating' => 'required|integer|between:1,5',
        'comment' => 'required|string',
    ]);
    $review = Review::create([
        'reviewable_id'   => $product->id,
        'reviewable_type' => Product::class,
        'customer_name'   => $request->name,
        'customer_email'  => $request->email,
        'rate'            => $request->rating,
        'description'     => $request->comment,
        'status'          => 1,
        'feature'         => 0,
    ]);


    return redirect()->back()->with('success-review', __('messages.review_submitted'));
}

}

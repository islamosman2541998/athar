<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewsRequest;

class ReviewsController extends Controller
{
    use FileHandler;





    public function index(Request $request)
    {
        $query = Review::query()->orderBy('id', 'DESC');

        if ($request->status != '') {
            if ($request->status == 1) $query->where('status', $request->status);
            else {
                $query->where('status', '!=', 1);
            }
        }
        if ($request->customer_name != '') {
            $query = $query->where('customer_name', 'like', '%' . request()->input('customer_name') . '%');
        }

        if ($request->description != '') {
            $query = $query->where('description', 'like', '%' . request()->input('description') . '%');
        }


        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.reviews.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.reviews.create');
    }


    public function store(ReviewsRequest $request)
    {
        $data = $request->getSanitized();

//        if ($request->hasFile('image')) {
//            $data['image'] = $this->upload_file($request->file('image'), ('reviews'));
//        }
//        Review::create($data);


        $review = Review::create($data);
        if ($request->image) {
            $image = $this->storeImage2($request, Review::staticPath(), $request->image, 'image');
            $review->image = $image;
            $review->save();
        }


        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect(route('admin.reviews.index'));
    }


    public function show(Review $review)
    {
        return view('admin.dashboard.reviews.show', compact('review'));
    }


    public function edit(Review $review)
    {
        return view('admin.dashboard.reviews.edit', compact('review'));
    }


    public function update(ReviewsRequest $request, Review $review)
    {

        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
//            @unlink($review->image);
//            $data['image'] = $this->upload_file($request->file('image'), ('reviews'));
            $this->deleteImage($review , 'image');
            $data['image'] = $this->storeImage2($request , $review->path() , $request->image , 'image');
        }
        $review->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Review $review)
    {
        if (file_exists(public_path() . $review->path() . $review->image)) {
            @unlink(public_path() . $review->path() . $review->image);
        }
        $review->updated_by = auth()->id();
        $review->save();

        $review->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $item = Review::findOrfail($id);
        $item->status == 1 ? $item->status = 0 : $item->status = 1;
        $item->updated_by = auth()->id();
        $item->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $item = Review::findOrfail($id);
        $item->feature == 1 ? $item->feature = 0 : $item->feature = 1;
        $item->updated_by = auth()->id();
        $item->save();
        return redirect()->back();
    }


    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $reviews = Review::findMany($request['record']);
            foreach ($reviews as $review) {
                $review->update(['status' => 1, 'updated_by' => auth()->id()]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $reviews = Review::findMany($request['record']);
            foreach ($reviews as $review) {
                $review->update(['status' => 0, 'updated_by' => auth()->id()]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $reviews = Review::findMany($request['record']);

            foreach ($reviews as $review) {
                $review->updated_by = auth()->id();
                $review->save();

                @unlink($review->image);
                $review->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}

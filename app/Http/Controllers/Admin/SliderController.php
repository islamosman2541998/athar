<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\SliderStoreRequest;

class SliderController extends Controller
{


    public $slider_path;


    public function __construct()
    {


        $this->slider_path = '/attachments/slider/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $q = Slider::query()->with('trans')->orderBy('id', 'ASC');

        if ($request->title != null) {

            $q->orWhereTranslationLike('title', '%' . $request->title . '%');
        }

        $sliders = $q->paginate($this->pagination_count);
        return view('admin.dashboard.Slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.Slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderStoreRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {

            $data['image'] = $this->storeImage2($request, '/attachments/slider/', $request->image, 'image');
        }

        if ($request->hasFile('mobile_image')) {
            $data['mobile_image'] = $this->storeImage2($request, '/attachments/slider/', $request->mobile_image, 'mobile_image');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $this->storeMedia($request->file('video'), $this->slider_path);
        }



        Slider::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        return view('admin.dashboard.Slider.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('admin.dashboard.Slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderStoreRequest $request, Slider $slider)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->deleteImage($slider, 'image');
            $data['image'] = $this->storeImage2($request, $this->slider_path, $request->image, 'image');
            //            @unlink($slider->image);
            //            $data['image'] = $this->upload_file($request->file('image'), ('slider'));
        }
        if ($request->hasFile('mobile_image')) {
            if ($slider->mobile_image) {
                @unlink(public_path($this->slider_path . $slider->mobile_image));
            }
            $data['mobile_image'] = $this->storeImage2($request, $this->slider_path, $request->mobile_image, 'mobile_image');
        }
        if ($request->hasFile('video')) {
            if ($slider->video) {
                @unlink(public_path($this->slider_path . $slider->video));
            }
            $data['video'] = $this->storeMedia($request->file('video'), $this->slider_path);
        }
        $slider->update($data);


        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    // Updated Status

    public function update_status($id)
    {
        $article = Slider::findOrfail($id);
        $article->status == 1 ? $article->status = 0 : $article->status = 1;
        $article->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $this->deleteImage($slider, 'image');
        if ($slider->mobile_image) {
            @unlink(public_path($this->slider_path . $slider->mobile_image));
        }
        $slider->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

    // Delete All

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $sliders = Slider::findMany($request['record']);
            foreach ($sliders as $slider) {
                $slider->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $sliders = Slider::findMany($request['record']);
            foreach ($sliders as $slider) {
                $slider->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $sliders = Slider::findMany($request['record']);
            foreach ($sliders as $slider) {
                @unlink($slider->image);
                $slider->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}

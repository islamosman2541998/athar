<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    public function index(Request $request)
    {
        $query = Gallery::query()->with('trans')->orderBy('id', 'ASC');

        if ($request->status  != '') {
            if ($request->status == 1) $query->where('status', $request->status);
            else {
                $query->where('status', '!=', 1);
            }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }

        if ($request->description != '') {
            $query = $query->orWhereTranslationLike('description', '%' . request()->input('description') . '%');
        }
        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.gallery.create');
    }


    public function store(GalleryRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('gallery'));
        }
        Gallery::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }


    public function show(Gallery $gallery)
    {
        return view('admin.dashboard.gallery.show', compact('gallery'));
    }


    public function edit(Gallery $gallery)
    {
        return view('admin.dashboard.gallery.edit', compact('gallery'));
    }


    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            @unlink($gallery->image);
            $data['image'] = $this->upload_file($request->file('image'), ('gallery'));
        }
        $gallery->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Gallery $gallery)
    {
        @unlink($gallery->image);
        $gallery->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }
    


    public function update_status($id)
    {
        $item = Gallery::findOrfail($id);
        $item->status == 1 ? $item->status = 0 : $item->status = 1;
        $item->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $item = Gallery::findOrfail($id);
        $item->feature == 1 ? $item->feature = 0 : $item->feature = 1;
        $item->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $galleries = Gallery::findMany($request['record']);
            foreach ($galleries as $gallery) {
                $gallery->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $galleries = Gallery::findMany($request['record']);
            foreach ($galleries as $gallery) {
                $gallery->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $galleries = Gallery::findMany($request['record']);
            foreach ($galleries as $gallery) {
                @unlink($gallery->image);
                $gallery->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}

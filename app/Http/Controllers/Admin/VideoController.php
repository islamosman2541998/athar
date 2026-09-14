<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::query()->with('trans')->orderBy('id', 'ASC');

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

        return view('admin.dashboard.videos.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.videos.create');
    }


    public function store(VideoRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('video'));
        }
        Video::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }


    public function show(Video $video)
    {
        return view('admin.dashboard.videos.show', compact('video'));
    }


    public function edit(Video $video)
    {
        return view('admin.dashboard.videos.edit', compact('video'));
    }


    public function update(VideoRequest $request, Video $video)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            @unlink($video->image);
            $data['image'] = $this->upload_file($request->file('image'), ('video'));
        }
        $video->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Video $video)
    {
        @unlink($video->image);
        $video->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $item = Video::findOrfail($id);
        $item->status == 1 ? $item->status = 0 : $item->status = 1;
        $item->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $item = Video::findOrfail($id);
        $item->feature == 1 ? $item->feature = 0 : $item->feature = 1;
        $item->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $videos = Video::findMany($request['record']);
            foreach ($videos as $video) {
                $video->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $videos = Video::findMany($request['record']);
            foreach ($videos as $video) {
                $video->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $videos = Video::findMany($request['record']);
            foreach ($videos as $video) {
                @unlink($video->image);
                $video->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}

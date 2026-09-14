<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query()->with('trans')->orderBy('id', 'ASC');

        if($request->status  != ''){
            $query->where('status', $request->status );
        }
        if ($request->title  != '') {
    
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
   
        if($request->description != ''){
            $query = $query->orWhereTranslationLike('description', '%' . request()->input('description') . '%');
        }
        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.news.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.news.create');
    }


    public function store(NewsRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('news'));
        }
        News::create($data);
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }


    public function show(News $news)
    {
        return view('admin.dashboard.news.show', compact('news'));
    }


    public function edit(News $news)
    {
        return view('admin.dashboard.news.edit', compact('news'));
    }


    public function update(NewsRequest $request, News $news)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            @unlink($news->image);
            $data['image'] = $this->upload_file($request->file('image'), ('news'));
        }
        $news->update($data);
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(News $news)
    {
        @unlink($news->image);
        $news->delete();
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $news = News::findOrfail($id);
        $news->status == 1 ? $news->status = 0 : $news->status = 1;
        $news->save();
        $this->clearHomeCache();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $news = News::findOrfail($id);
        $news->feature == 1 ? $news->feature = 0 : $news->feature = 1;
        $news->save();
        $this->clearHomeCache();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $news = News::findMany($request['record']);
            foreach ($news as $new) {
                $new->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $news = News::findMany($request['record']);
            foreach ($news as $new) {
                $new->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $news = News::findMany($request['record']);
            foreach ($news as $new) {
                @unlink($new->image);
                $new->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        $this->clearHomeCache();
        return redirect()->back();
    }
}

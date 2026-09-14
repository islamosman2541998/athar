<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagRequest;

class TagController extends Controller
{

    public function index(Request $request)
    {
        $query = Tag::query()->with('trans')->orderBy('id','ASC');
        if($request->status  != ''){
            $query->where('status', $request->status );
        }
        if($request->title  != ''){
            $query->orWhereTranslationLike('title','%'.$request->title.'%');
        }
        if($request->description != ''){
            $query->orWhereTranslationLike('description','%'.$request->title.'%');

        }
        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.Tags.index',compact('items'));
    }


    public function create()
    {
        return view('admin.dashboard.Tags.create');
    }


    public function store(TagRequest $request)
    {
        $data = $request->getSanitized();
        if($request->hasFile('image')){
            $data['image'] = $this->upload_file($request->file('image') , ('Tags'));
        }
        if($request->hasFile('background_image')){
            $data['background_image'] = $this->upload_file($request->file('background_image') , ('Tags'));
        }
        Tag::create($data);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        return back();
    }

    public function show(Tag $tag)
    {
        return view('admin.dashboard.Tags.show',compact('tag'));   

    }


    public function edit(Tag $tag)
    {
    return view('admin.dashboard.Tags.edit',compact('tag'));   
    }


    public function update(TagRequest $request, Tag $tag)
    {
        
        $data = $request->getSanitized();
        if($request->hasFile('image')){
            @unlink($tag->image);
            $data['image'] = $this->upload_file($request->file('image') , ('Tags'));
        }
        if($request->hasFile('background_image')){
            @unlink($tag->background_image);

            $data['background_image'] = $this->upload_file($request->file('background_image') , ('Tags'));
        }
        $tag->update($data);
         session()->flash('success' , trans('message.admin.updated_sucessfully') );
         return  redirect()->back();
    }


    public function destroy(Tag $tag)
    {
        @unlink($tag->image);
        $tag->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->back();
    }


    //Method Update status
    public function update_status($id){
        $tag = Tag::findOrfail($id);
        $tag->status == 1 ? $tag->status = 0 : $tag->status = 1;
        $tag->save();
        return redirect()->back();
    }
    // Method Update Featured
    public function update_featured($id){
        $tag = Tag::findOrfail($id);
        $tag->feature == 1 ? $tag->feature = 0 : $tag->feature = 1;
        $tag->save();
        return redirect()->back();
    }

    // Method Update All Status And delete All
        // Delete All 

        public function actions(Request $request){
            if($request['publish'] == 1 ){
                $tags = Tag::findMany($request['record']);
                foreach ($tags as $tag){
                    $tag->update(['status' => 1]);
                }
                session()->flash('success' , trans('articles.status_changed_sucessfully') );
            }
            if($request['unpublish'] == 1 ){
                $tags = Tag::findMany($request['record']);
                foreach ($tags as $tag){
                    $tag->update(['status' => 0]);
                }
                session()->flash('success' , trans('articles.status_changed_sucessfully') );
            }
            if($request['delete_all'] == 1 ){
                $tags = Tag::findMany($request['record']);
                foreach ($tags as $tag){
                    @unlink($tag->image);
                    @unlink($tag->background_image);
                    $tag->delete();
                }
                session()->flash('success' , trans('pages.delete_all_sucessfully') );
            }
            return redirect()->back();
        }
}

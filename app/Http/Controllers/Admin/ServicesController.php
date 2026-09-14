<?php

namespace App\Http\Controllers\Admin;

use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServicesRequest;

class ServicesController extends Controller
{ 
    public function index(Request $request)
    {
        $query = Services::query()->with(['trans','category.trans'])->orderBy('id', 'ASC');

    
        if($request->status  != ''){
            if( $request->status == 1) $query->where('status', $request->status );
            else{  $query->where('status', '!=', 1); }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
   
        if($request->description != ''){
            $query = $query->orWhereTranslationLike('description', '%' . request()->input('description') . '%');

        }
        
        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.services.index', compact('items'));
    }

    public function create()
    {
            $categories = \App\Models\ServiceCategory::with('trans')->active()->orderBy('sort')->get();

        return view('admin.dashboard.services.create', compact('categories'));
    }


    public function store(ServicesRequest $request)
    {
        $data = $request->getSanitized();
            $data['service_category_id'] = $request->input('service_category_id');


        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('services'));
        }
        Services::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }


    public function show(Services $service)
    {
        return view('admin.dashboard.services.show', compact('service'));
    }


    public function edit(Services $service)
    {
                    $categories = \App\Models\ServiceCategory::with('trans')->active()->orderBy('sort')->get();

        return view('admin.dashboard.services.edit', compact('service','categories'));
    }


    public function update(ServicesRequest $request,Services $service)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            @unlink($service->image);
            $data['image'] = $this->upload_file($request->file('image'), ('services'));
        }
        $service->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Services $service)
    {
        @unlink($service->image);
        $service->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $article = Services::findOrfail($id);
        $article->status == 1 ? $article->status = 0 : $article->status = 1;
        $article->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $article = Services::findOrfail($id);
        $article->feature == 1 ? $article->feature = 0 : $article->feature = 1;
        $article->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $services = Services::findMany($request['record']);
            foreach ($services as $service) {
                $service->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $services = Services::findMany($request['record']);
            foreach ($services as $service) {
                $service->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $services = Services::findMany($request['record']);
            foreach ($services as $service) {
                @unlink($service->image);
                $service->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Specialties;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpecialtiesRequest;

class SpecialtiesController extends Controller
{
    public function index(Request $request)
    {
        $query = Specialties::query()->with('trans')->orderBy('id', 'ASC');

    
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

        return view('admin.dashboard.specialties.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.specialties.create');
    }


    public function store(SpecialtiesRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('specialties'));
        }
        Specialties::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }


    public function show(Specialties $specialty)
    {
        return view('admin.dashboard.specialties.show', compact('specialty'));
    }


    public function edit(Specialties $specialty)
    {
        return view('admin.dashboard.specialties.edit', compact('specialty'));
    }


    public function update(SpecialtiesRequest $request, Specialties $specialty)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            @unlink($specialty->image);
            $data['image'] = $this->upload_file($request->file('image'), ('specialties'));
        }
        $specialty->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Specialties $specialty)
    {
        @unlink($specialty->image);
        $specialty->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $article = Specialties::findOrfail($id);
        $article->status == 1 ? $article->status = 0 : $article->status = 1;
        $article->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $article = Specialties::findOrfail($id);
        $article->feature == 1 ? $article->feature = 0 : $article->feature = 1;
        $article->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $specialties = Specialties::findMany($request['record']);
            foreach ($specialties as $specialty) {
                $specialty->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $specialties = Specialties::findMany($request['record']);
            foreach ($specialties as $specialty) {
                $specialty->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $specialties = Specialties::findMany($request['record']);
            foreach ($specialties as $specialty) {
                @unlink($specialty->image);
                $specialty->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}

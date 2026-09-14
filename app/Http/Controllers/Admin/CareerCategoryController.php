<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CareerCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CareerCategoryRequest;

class CareerCategoryController extends Controller
{

    public function index(Request $request)
    {
        $query = CareerCategory::query()->with('trans')->orderBy('id','ASC');
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
        return view('admin.dashboard.careercategory.index',compact('items'));
    }


    public function create()
    {
        return view('admin.dashboard.careercategory.create');
    }


    public function store(CareerCategoryRequest $request)
    {
        $data = $request->getSanitized();
        CareerCategory::create($data);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        return back();
    }

    public function show(CareerCategory $careerCategory)
    {
        return view('admin.dashboard.careercategory.show',compact('careerCategory'));   

    }


    public function edit(CareerCategory $careerCategory){
        return view('admin.dashboard.careercategory.edit',compact('careerCategory'));   
    }


    public function update(CareerCategoryRequest $request, CareerCategory $careerCategory)
    {
        $data = $request->getSanitized();
        $careerCategory->update($data);
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        return  redirect()->back();
    }


    public function destroy(CareerCategory $careerCategory)
    {
        @unlink($careerCategory->image);
        $careerCategory->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->back();
    }


    //Method Update status
    public function update_status($id){
        $careerCategory = CareerCategory::findOrfail($id);
        $careerCategory->status == 1 ? $careerCategory->status = 0 : $careerCategory->status = 1;
        $careerCategory->save();
        return redirect()->back();
    }
    // Method Update Featured
    public function update_featured($id){
        $careerCategory = CareerCategory::findOrfail($id);
        $careerCategory->feature == 1 ? $careerCategory->feature = 0 : $careerCategory->feature = 1;
        $careerCategory->save();
        return redirect()->back();
    }

    // Method Update All Status And delete All
        // Delete All 

        public function actions(Request $request){
            if($request['publish'] == 1 ){
                $careerCategories = CareerCategory::findMany($request['record']);
                foreach ($careerCategories as $careerCategory){
                    $careerCategory->update(['status' => 1]);
                }
                session()->flash('success' , trans('articles.status_changed_sucessfully') );
            }
            if($request['unpublish'] == 1 ){
                $careerCategories = CareerCategory::findMany($request['record']);
                foreach ($careerCategories as $careerCategory){
                    $careerCategory->update(['status' => 0]);
                }
                session()->flash('success' , trans('articles.status_changed_sucessfully') );
            }
            if($request['delete_all'] == 1 ){
                $careerCategories = CareerCategory::findMany($request['record']);
                foreach ($careerCategories as $careerCategory){
                    @unlink($careerCategory->image);
                    @unlink($careerCategory->background_image);
                    $careerCategory->delete();
                }
                session()->flash('success' , trans('pages.delete_all_sucessfully') );
            }
            return redirect()->back();
        }
}

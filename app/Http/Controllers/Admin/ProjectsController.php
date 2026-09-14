<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectsRequest;
use App\Models\Images;
use App\Models\Projects;
use App\Models\Portfolios;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public $portfolio;

    public function __construct()
    {
        $this->portfolio = Portfolios::query()->with('trans')->get();
    }
    
    public function index(Request $request)
    {
        
        $query = Projects::query()->with('trans', 'portfolio')->orderBy('id', 'ASC');
        $portfolios = $this->portfolio;
    
        if($request->status  != ''){
            if( $request->status == 1) $query->where('status', $request->status );
            else{  $query->where('status', '!=', 1); }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        if($request->portfolio_id != ''){
            $query = $query->where('portfolio_id',  request()->input('portfolio_id') );
        }
        
        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.projects.index', compact('items', 'portfolios'));
    }

    public function create()
    {
        $portfolios = $this->portfolio;
        return view('admin.dashboard.projects.create', compact('portfolios'));
    }


    public function store(ProjectsRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('project'));
        }
        $project = Projects::create($data);

        if (@$data['gallery'] != null || @$data['gallery'] != []) {
            foreach($data['gallery'] as $key => $gallery){
                if($gallery != null){ $img = upload_file( $gallery['image'] , ('images'));  }
                    Images::create([
                    'url' =>  $img,
                    'sort' => $gallery['sort'],
                    'image_type' => 'image',
                    'parentable_id' => $project->id,
                    'parentable_type' => Projects::class
                    ]);
               
            }
            $data['image'] = $this->upload_file($request->file('image'), ('project'));
        }

        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }


    public function show(Projects $project)
    {
        return view('admin.dashboard.projects.show', compact('project'));
    }


    public function edit(Projects $project)
    {
        $portfolios = $this->portfolio;
        return view('admin.dashboard.projects.edit', compact('project', 'portfolios'));
    }


    public function update(ProjectsRequest $request, Projects $project)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            @unlink($project->image);
            $data['image'] = $this->upload_file($request->file('image'), ('project'));
        }
        $project->update($data);
        
        $this->updateImages($data, $project);
  
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Projects $project)
    {
        @unlink($project->image);
        $project->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $project = Projects::findOrfail($id);
        $project->status == 1 ? $project->status = 0 : $project->status = 1;
        $project->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $project = Projects::findOrfail($id);
        $project->feature == 1 ? $project->feature = 0 : $project->feature = 1;
        $project->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $projects = Projects::findMany($request['record']);
            foreach ($projects as $project) {
                $project->update(['status' => 1]);
            }
            session()->flash('success', trans('project.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $projects = Projects::findMany($request['record']);
            foreach ($projects as $project) {
                $project->update(['status' => 0]);
            }
            session()->flash('success', trans('project.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $projects = Projects::findMany($request['record']);
            foreach ($projects as $project) {
                @unlink($project->image);
                $project->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }

    public function updateImages($data, $project){
        // delete gallery ===============================================
            $oldGallery = $project->images;
            $updateGallery = @$data['gallery']['id'];
            $removeGallery = $oldGallery->whereNotIn('id',  $updateGallery);
            if(!empty($removeGallery)){
                foreach($removeGallery as $removeItem){
                    @unlink(@$removeItem->url);
                    $removeItem->delete();
                }
            }
        if (@$data['gallery'] != null || @$data['gallery'] != []) {
            // update gallery ===============================================
    
            if($updateGallery != null){
                foreach($updateGallery as $key => $updateItem){
                    $item = $oldGallery->where('id', $updateItem)->first();
                    if(!is_string($data['gallery']['image'][$key] ) && $data['gallery']['image'][$key]  != null){ 
                        @unlink(@$item->url);
                        $img = $this->upload_file( @$data['gallery']['image'][$key] , ('images'));
                    }
                    else{
                        $img = @$data['gallery']['image'][$key];
                    }
                    if( $item != null)
                    $item->update([
                        'sort' =>  @$data['gallery']['sort'][$key],
                        'url' =>   $img,
                    ]);
                }
            }
        }
    // Add gallery ===============================================

        if (@$data['newgallery'] != null || @$data['newgallery'] != []) {
            foreach($data['newgallery'] as $key => $gallery){
                if(!is_string($gallery) && $gallery != null){ 
                    $img = $this->upload_file( $gallery['image'] , ('images'));
                    Images::create([
                        'url' =>  $img,
                        'sort' => $gallery['sort'],
                        'image_type' => 'image',
                        'parentable_id' => $project->id,
                        'parentable_type' => Projects::class
                    ]);  
                }
            }
        }
    }
}

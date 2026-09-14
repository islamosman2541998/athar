<?php

namespace App\Http\Controllers\Admin;

use App\Models\Statistic ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StatisticRequest;
use App\Models\Tag;

class StatisticController extends Controller
{

    public function __construct()
    {
    }
    
    public function index(Request $request)
    {

        $query = Statistic::query()->with('trans')->orderBy('id', 'ASC');
    
        if($request->status  != ''){
            if( $request->status == 1) $query->where('status', $request->status );
            else{  $query->where('status', '!=', 1); }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
   
       

        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.statistic.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.statistic.create');
    }


    public function store(StatisticRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('statistic'));
        }
        Statistic::create($data);
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }


    public function show(Statistic $statistic)
    {
        return view('admin.dashboard.statistic.show', compact('statistic'));
    }


    public function edit(Statistic $statistic)
    {
        return view('admin.dashboard.statistic.edit', compact('statistic'));
    }


    public function update(StatisticRequest $request, Statistic $statistic)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            @unlink($statistic->image);
            $data['image'] = $this->upload_file($request->file('image'), ('statistic'));
        }
        $statistic->update($data);
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Statistic $statistic)
    {
        @unlink($statistic->image);
        $statistic->delete();
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $statistic = Statistic::findOrfail($id);
        $statistic->status == 1 ? $statistic->status = 0 : $statistic->status = 1;
        $statistic->save();
        $this->clearHomeCache();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $statistic = Statistic::findOrfail($id);
        $statistic->feature == 1 ? $statistic->feature = 0 : $statistic->feature = 1;
        $statistic->save();
        $this->clearHomeCache();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $Statistic = Statistic::findMany($request['record']);
            foreach ($Statistic as $statistic) {
                $statistic->update(['status' => 1]);
            }
            session()->flash('success', trans('statistic.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $Statistic = Statistic::findMany($request['record']);
            foreach ($Statistic as $statistic) {
                $statistic->update(['status' => 0]);
            }
            session()->flash('success', trans('statistic.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $Statistic = Statistic::findMany($request['record']);
            foreach ($Statistic as $statistic) {
                @unlink($statistic->image);
                $statistic->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        $this->clearHomeCache();
        return redirect()->back();
    }
}

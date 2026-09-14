<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Http\Requests\Admin\FooterMenuRequest;

class FooterMenuController extends Controller
{
    public function index()
    {
        return view('livewire.admin.footer-menus.index');
 
    }

    public function create(){
        $query = Menue::query()->footer()->with('trans');
        $ids = arrang_records( $query->get());

        if($ids) $menus = $query->whereIn('id', $ids)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $menus = $query->get();
       
        return view('admin.dashboard.footer-menus.create', compact('menus'));
        
    }

    public function createMenu($id)
    {
        $item_parent_id = $id;
        $createMode = true;
        $items =  collect(Menue::query()->footer()->with('trans')->get());
        return view('admin.dashboard.footer-menus.index',compact('items', 'item_parent_id', 'createMode'));
        
    }


    public function store(FooterMenuRequest $request)
    {
         $data = $request->getSanitized();
         $item = Menue::create($data);
         session()->flash('success' , trans('message.admin.created_sucessfully') );
         return redirect()->route('admin.footer-menus.create');
    }

    public function show(Menue $footer_menu)
    {
        return view('admin.dashboard.footer-menus.show',compact('footer_menu'));
    }


    public function edit(Menue $footer_menu)
    {
        $item = $footer_menu;
        $query = Menue::query()->footer()->with('trans')->get();
        $childs =  get_childs_id($item->children,  $query);
        $ids = arrang_records( $query);
        if($ids)$menus = Menue::query()->footer()->with('trans')->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id','!=',  $item->id)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        return view('admin.dashboard.footer-menus.edit',compact('footer_menu', 'menus'));

    }

    public function update(FooterMenuRequest $request, Menue $footer_menu)
    {
        $data = $request->getSanitized();
        $footer_menu->update($data);
        $query = Menue::query()->with('trans')->get();
        update_childs_level($footer_menu,  $query);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Menue $menu) {  
        $menu->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->route('admin.footer-menus.index');
    }

    public function update_status($id){
        $menu = Menue::findOrfail($id);
        $menu->status == 1 ? $menu->status = 0 : $menu->status = 1;
        $menu->save();
        return redirect()->back();
    }


    public function actions(Request $request){
        if($request['publish'] == 1 ){
            $menus = Menue::findMany($request['record']);
            foreach ($menus as $menu){
                $menu->update(['status' => 1]);
            }
            session()->flash('success' , trans('pages.status_changed_sucessfully') );
        }
        if($request['unpublish'] == 1 ){
            $menus = Menue::findMany($request['record']);
            foreach ($menus as $menu){
                $menu->update(['status' => 0]);
            }
            session()->flash('success' , trans('pages.status_changed_sucessfully') );
        }
        if($request['delete_all'] == 1 ){
            $menus = Menue::findMany($request['record']);
            foreach ($menus as $menu){
                
                $menu->delete();
            }
            session()->flash('success' , trans('pages.delete_all_sucessfully') );
        }
        return redirect()->back();
    }




    public function show_tree(Request $request)
    {
        $items =  Menue::query()->footer()->with('trans')->get();
        $searchItem = [];
        if($request->title){
            $searchItem = Menue::query()->footer()->with('trans')->WhereTranslationLike('title', '%' . $request->title . '%')->get();  
        }
        return view('admin.dashboard.footer-menus.index',compact('items', 'searchItem'));   
    }
}


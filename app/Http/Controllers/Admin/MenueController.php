<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuPositionEnums;
use App\Enums\UrlTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Blog;
use App\Models\Job;
use App\Models\Menue;
use App\Models\News;
use App\Models\Pages;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class MenueController extends Controller
{

    public function index(){
        return view('livewire.admin.menus.index');
    }

    public function create() {
        return view('admin.dashboard.menus.create');

    }

    public function getMenus(Request $request){

        $query = Menue::query()->with('trans');
        $ids = arrang_records( $query->get());

        if($request->position == MenuPositionEnums::MAIN){
            if($ids) $menus = $query->whereIn('id', $ids)->main()->orderByRaw("field(id,".implode(',',$ids).")")->get();
            else $menus = $query->get();
        }
        elseif($request->position == MenuPositionEnums::FOOTER){
            if($ids) $menus = $query->whereIn('id', $ids)->footer()->orderByRaw("field(id,".implode(',',$ids).")")->get();
            else $menus = $query->get();
        }

        foreach($menus as $menu){
            $menu->name = $menu->trans->where('locale', app()->getLocale())->first()->title;
        }
        return $menus;
    }

    public function createMenu($id) {
        $item_parent_id = $id;
        $createMode = true;
        $items =  collect(Menue::query()->main()->with('trans')->get());
        return view('admin.dashboard.menus.index',compact('items', 'item_parent_id', 'createMode'));

    }


    public function store(MenuRequest $request)
    {
        Cache::forget('menus');
        Cache::forget('footer-menus');

         $data = $request->getSanitized();
         Menue::create($data);
         session()->flash('success' , trans('message.admin.created_sucessfully') );
         return redirect()->route('admin.menus.create');
    }

    public function show(Menue $menu){
        return view('admin.dashboard.menus.show',compact('menu'));
    }


    public function edit(Menue $menu)
    {
        Cache::forget('menus');
        Cache::forget('footer-menus');
        $item = $menu;
        if($menu->position == MenuPositionEnums::FOOTER){
            $menus = Menue::query()->footer()->with('trans')->get();
        }
        else{
            $menus = Menue::query()->main()->with('trans')->get();
        }
        $childs =  get_childs_id($item->children,  $menus);
        $ids = arrang_records( $menus);
        if($ids) $menus = Menue::query()->with('trans')->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id','!=',  $item->id)->orderByRaw("field(id,".implode(',',$ids).")")->get();

        return view('admin.dashboard.menus.edit',compact('menu', 'menus'));

    }

    public function update(MenuRequest $request, Menue $menu)
    {
        Cache::forget('menus');
        Cache::forget('footer-menus');

        $data = $request->getSanitized();
        $menu->update($data);
        $query = Menue::query()->with('trans')->get();
        update_childs_level($menu,  $query);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Menue $menu) {
        Cache::forget('menus');
        Cache::forget('footer-menus');

        $menu->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->route('admin.menus.index');
    }

    public function update_status($id){
        Cache::forget('menus');
        Cache::forget('footer-menus');

        $menu = Menue::findOrfail($id);
        $menu->status == 1 ? $menu->status = 0 : $menu->status = 1;
        $menu->save();
        return redirect()->back();
    }


    public function actions(Request $request){
        Cache::forget('menus');
        Cache::forget('footer-menus');

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
        if($request->position == MenuPositionEnums::FOOTER){
            $items =  Menue::query()->footer()->with('trans')->get();
        }
        else{
            $items =  Menue::query()->main()->with('trans')->get();
         }
        $searchItem = [];
        if($request->title){
            $searchItem = Menue::query()->main()->with('trans')->WhereTranslationLike('title', '%' . $request->title . '%')->get();
        }
        return view('admin.dashboard.menus.index',compact('items', 'searchItem'));
    }



    public function getUrl(Request $request){
        $name = $request->name;

        $res = [];
        if($name == UrlTypesEnum::PAGES){
            $items = Pages::query()->with('trans')->active()->get(['id']);
            foreach($items as $item){
                $res[] =  '/pages/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }

        if($name == UrlTypesEnum::CATEGORIES){
            $items = ProductCategory::query()->with('trans')->active()->get(['id']);
            foreach($items as $item){
                $res[] =  '/categories/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        if($name == UrlTypesEnum::SERVICES){
            $items = Services::query()->with('trans')->active()->get(['id']);
            foreach($items as $item){
                $res[] =  '/services/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        if($name == UrlTypesEnum::CATEGORIESSERVICES){
            $items = ServiceCategory::query()->with('trans')->active()->get(['id']);
            foreach($items as $item){
                $res[] =  '/categories-services/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        if($name == UrlTypesEnum::PRODUCTS){
            $items = Product::query()->with('trans')->active()->get(['id']);
            foreach($items as $item){
                $res[] =  '/products/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        if($name == UrlTypesEnum::BLOGS){
            $items = Blog::query()->with('trans')->get(['id']);
            foreach($items as $item){
                $res[] =  '/blogs/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
                // $res[] =  '/blogs/' . $item->id;
            }
        }
        if($name == UrlTypesEnum::NEWS){
            $items = News::query()->with('trans')->active()->get(['id']);
            foreach($items as $item){
                $res[] =  '/news/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
            }
        }
        if($name == UrlTypesEnum::JOBS){

            $items = Job::query()->with('trans')->active()->get(['id']);
            foreach($items as $item){
                // $res[] =  '/jobs/' . $item->trans->where("locale", app()->getLocale())->first()->slug;
                $res[] =  '/jobs/' . $item->id;
            }
        }
        return $res;
    }

}

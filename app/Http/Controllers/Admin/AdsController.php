<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class AdsController extends Controller
{

    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $data = $request->except(['_token']);
        return view('admin.dashboard.ads.create', compact('data'));
    }

   
    public function store(Request $request)
    {
        $data = $request->all();
        if($data['ads'] != [] ){
            foreach($data['ads'] as $key => $ads){
                if($ads['image'] != null){
                    $ads['image'] = upload_file( $ads['image'] , ('ads'));
                }
                $adsModel = Ads::create([
                    'model_id' => $data['id'],
                    'model'    =>  $data['model'],
                    'image'    => @$ads['image'],
                    'link'     => @$ads['link'],
                ]);
            }
        }
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        return redirect()->route('admin.ads.edit', ['id' => $adsModel->model_id, 'model'=> $adsModel->model]);
    }


    public function show(Request $request)
    {
        $data = $request->all();
        $items = Ads::query()->where('model_id', $data['id'])->where('model', $data['model'])->get();
        return view('admin.dashboard.ads.show', compact('items'));
    }


    public function edit(Request $request)
    {
        $data = $request->all();
        $items = Ads::query()->where('model_id', $data['id'])->where('model', $data['model'])->get();
        return view('admin.dashboard.ads.edit', compact('data', 'items'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $ads = $data['ads'];
        $items = Ads::query()->where('model_id', $data['id'])->where('model', $data['model'])->get();
        if(!empty($items)){
            foreach( $items as $item){
                if(!in_array($item->image,  $ads['image'])){
                    @unlink($item->image);
                }
                $item->delete();
            }
        }
    
        if(!empty($ads)){
            foreach($ads['link'] as $key =>$ad){
                if(!is_string($ads['image'][$key])){
                    $ads['image'][$key] = upload_file( $ads['image'][$key] , ('ads'));
                }
                Ads::create([
                    'model_id' => $data['id'],
                    'model'    =>  $data['model'],
                    'image'    => @$ads['image'][$key],
                    'link'     => @$ad,
                ]);           
            }
        }
        return redirect()->back();
    }


    public function destroy($id)
    {
        //
    }
}

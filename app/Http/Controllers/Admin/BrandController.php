<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandStoreRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Brand::query()->with('trans')->orderBy('id', 'ASC');

        if (request()->input('title')  != '') {
            $query = $query->WhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.brand.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandStoreRequest $request)
    {

        $data = $request->getSanitized();
        // dd($data);
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('brands'));
        }
        Brand::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view('admin.dashboard.brand.show', compact('brand'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('admin.dashboard.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandStoreRequest $request, Brand $brand)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            @unlink($brand->image);
            $data['image'] = $this->upload_file($request->file('image'), ('brand'));
        }
        $brand->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        @unlink($brand->image);
        $brand->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $page = Brand::findOrfail($id);
        $page->status == 1 ? $page->status = 0 : $page->status = 1;
        $page->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $brands = Brand::findMany($request['record']);
            foreach ($brands as $brand) {
                $brand->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $brands = Brand::findMany($request['record']);
            foreach ($brands as $brand) {
                $brand->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $brands = Brand::findMany($request['record']);
            foreach ($brands as $brand) {
                @unlink($brand->image);
                $brand->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}

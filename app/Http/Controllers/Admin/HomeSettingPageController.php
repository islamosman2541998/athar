<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\HomeSettingPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HomeSettingPageRequest;

class HomeSettingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = HomeSettingPage::query()->with('trans')->get(['title_section', 'id', 'status']);

        return view('admin.dashboard.home_setting_page.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.home_setting_page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HomeSettingPageRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('HomeSetting'));
        }
        HomeSettingPage::create($data);
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeSettingPage $homeSetting)
    {

        return view('admin.dashboard.home_setting_page.edit', compact('homeSetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HomeSettingPageRequest $request, HomeSettingPage $homeSetting)
    {

        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            @unlink($homeSetting->image);
            $data['image'] = $this->upload_file($request->file('image'), ('HomeSetting'));
        }
        if ($request->hasFile('pdf')) {
            @unlink($homeSetting->image);
            $data['pdf'] = $this->upload_file($request->file('pdf'), ('HomeSetting'));
        }
        $homeSetting->update($data);
        $this->clearHomeCache();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }
    public function update_status($id)
    {
        $news = HomeSettingPage::findOrfail($id);
        $news->status == 1 ? $news->status = 0 : $news->status = 1;
        $news->save();
        $this->clearHomeCache();
        session()->flash('success', trans('articles.status_changed_sucessfully'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

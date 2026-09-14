<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;

class ProfileController extends Controller
{

    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }

 
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::query()->select(['name'])->get();
        return view('admin.dashboard.profile.edit',compact('user', 'roles'));
    }

 

    public function update(ProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->getSanitized();
        $data['password'] = $data['password']? bcrypt($data['password']) : $user->password;
        if($request->hasFile('image')){
            $data['image'] = $this->upload_file($request->file('image') , ('users'));
        }
        $user->update($data);
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        return  redirect()->back();
    }
   
    public function destroy($id)
    {
        //
    }
}

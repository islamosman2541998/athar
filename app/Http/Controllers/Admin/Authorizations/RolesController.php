<?php

namespace App\Http\Controllers\Admin\Authorizations;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolesRequest;

class RolesController extends Controller
{
    public function __construct()
    {
        if (app()->runningInConsole()) {
            return;
        }
        $model = Permission::query()->get();
        syncPermisions($model);
    }

    public function index()
    {
        $items = Role::query()->with('permissions:name')->paginate($this->pagination_count);
        return view('admin.dashboard.authorization.roles.index' , compact('items')); 
       }


    public function create()
    {
        $permissions = Permission::query()->get();
        return view('admin.dashboard.authorization.roles.create', compact('permissions') );
    }

    public function store(RolesRequest $request)
    {
        $data = $request->getSanitized();
        $role = Role::create(['name'=>$data['name'], 'guard_name'=> 'web']);
        $role->permissions()->attach($data['permissions']);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        return back();    }


    public function show(Role $Role)
    {
        return view('admin.dashboard.authorization.roles.show' , compact('Role'));
    }


    public function edit(Role $Role)
    {
        $permissions = Permission::with('permissions')->get();
        return view('admin.dashboard.authorization.roles.edit' , compact('Role','permissions'));
    }


    public function update(RolesRequest $request,Role $Role)
    {
        $Role->update($request->getSanitized());
        $Role->syncPermissions($request->getSanitized()['permissions']);
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        return back();
    }


    public function destroy(Role $Role)
    {
        try {
            $Role->delete();
        } catch (\Exception $e) {
        }
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return back();   
     }
}

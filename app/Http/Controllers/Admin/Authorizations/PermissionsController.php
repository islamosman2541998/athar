<?php

namespace App\Http\Controllers\Admin\Authorizations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\PermissionsRequest;

class PermissionsController extends Controller
{
    protected $model_permission = '_permissions';


    public function index()
    {
        // abort_unless(Gate::allows('index'.$this->model_permission) , 403);

        $query = Permission::query();

        if (request()->has('name'))
            $query->where('name' , 'like' , '%' . request('name') .'%');

        $items = $query->with('permissions:name')->paginate($this->pagination_count);

        return view('admin.dashboard.authorization.permissions.index', compact('items'));
    }


    public function create()
    {
        // abort_unless(Gate::allows('create'.$this->model_permission) , 403);
        return view('admin.dashboard.authorization.permissions.create');
    }


    public function store(PermissionsRequest $request)
    {
        // abort_unless(Gate::allows('create'.$this->model_permission) , 403);
        $data =$request->getSanitized();

        Permission::create($data);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        return back();
    }


    public function show($id)
    {
        //
    }

    public function edit(Permission $Permission)
    {
    
        // abort_unless(Gate::allows('edit'.$this->model_permission) , 403);
        // $item = $Permission;
        return view('admin.dashboard.authorization.permissions.edit' , compact('Permission'));

    }

   
    public function update(PermissionsRequest $request, Permission $Permission)
    {
        // abort_unless(Gate::allows('edit'.$this->model_permission) , 403);
        $Permission->update($request->getSanitized());
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        return back();
    }

    
    public function destroy(Permission $Permission)
    {
        // abort_unless(Gate::allows('delete'.$this->model_permission) , 403);
        try {
            $Permission->delete();
        } catch (\Exception $e) {
        }
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return back();
    }

    public function RestoreAllRoutes(){
        $permissions = Permission::query()->get();
        syncPermisions($permissions);
        session()->flash('success' , trans('message.admin.restore_permissions_sucessfully') );
        return back();
    }

}

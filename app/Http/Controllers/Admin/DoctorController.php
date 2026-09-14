<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DoctorRequest;
use App\Models\Doctor;
use App\Models\Specialties;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function index(Request $request)
    {
        $query = Doctor::query()->with('trans')->orderBy('id', 'ASC');

    
        if($request->status  != ''){
            if( $request->status == 1) $query->where('status', $request->status );
            else{  $query->where('status', '!=', 1); }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        
        if($request->description != ''){
            $query = $query->orWhereTranslationLike('description', '%' . request()->input('description') . '%');
        }

        if ($request->specialty_id  != '') {
            $query = $query->where('specialty_id', $request->specialty_id);
        }
        $items = $query->paginate($this->pagination_count);

        $specialties = Specialties::with('trans')->get('id');

        return view('admin.dashboard.doctors.index', compact('items', 'specialties'));
    }

    public function create()
    {
        $specialties = Specialties::with('trans')->get('id');
        return view('admin.dashboard.doctors.create', compact('specialties'));
    }


    public function store(DoctorRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('doctors'));
        }
        Doctor::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }


    public function show(Doctor $doctor)
    {
        return view('admin.dashboard.doctors.show', compact('doctor'));
    }


    public function edit(Doctor $doctor)
    {
        $specialties = Specialties::with('trans')->get('id');
        return view('admin.dashboard.doctors.edit', compact('doctor', 'specialties'));
    }


    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            @unlink($doctor->image);
            $data['image'] = $this->upload_file($request->file('image'), ('doctors'));
        }
        $doctor->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Doctor $doctor)
    {
        @unlink($doctor->image);
        $doctor->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $item = Doctor::findOrfail($id);
        $item->status == 1 ? $item->status = 0 : $item->status = 1;
        $item->save();
        return redirect()->back();
    }

    public function update_featured($id)
    {
        $item = Doctor::findOrfail($id);
        $item->feature == 1 ? $item->feature = 0 : $item->feature = 1;
        $item->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $doctors = Doctor::findMany($request['record']);
            foreach ($doctors as $doctor) {
                $doctor->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $doctors = Doctor::findMany($request['record']);
            foreach ($doctors as $doctor) {
                $doctor->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $doctors = Doctor::findMany($request['record']);
            foreach ($doctors as $doctor) {
                @unlink($doctor->image);
                $doctor->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}

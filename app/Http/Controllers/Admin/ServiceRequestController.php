<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cv;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
{
    $query = ServiceRequest::with('service_category')->orderBy('created_at', 'desc');

  
    if ($request->filled('name')) {
        $name = trim($request->input('name'));
        $query->where('name', 'like', "%{$name}%");
    }

    if ($request->filled('email')) {
        $email = trim($request->input('email'));
        $query->where('email', 'like', "%{$email}%");
    }

    if ($request->filled('phone')) {
        $phone = trim($request->input('phone'));
        $query->where('phone', 'like', "%{$phone}%");
    }
if ($request->filled('company')) {
        $company = trim($request->input('company'));
        $query->where('company', 'like', "%{$company}%");
    }

    $service_requests = $query->paginate(20)->appends($request->only(['name', 'email', 'phone', 'company', 'service_category_id', 'message', 'timeline' ]));

    return view('admin.dashboard.servicerequest.index', compact('service_requests'));
}


    public function destroy (ServiceRequest $serviceRequest)
    {
        $serviceRequest->delete();
        return back()->with('success', 'Service request deleted');
    }

}
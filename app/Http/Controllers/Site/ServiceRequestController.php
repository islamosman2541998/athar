<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\ServiceCategory;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $serviceCategories = ServiceCategory::active()->with('transNow')->orderBy('sort')->get();
        return view('site.pages.servicerequest.index', compact('serviceCategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'company' => ['nullable', 'string', 'max:255'],
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'timeline' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:3000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,zip', 'max:10240'],
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = basename($request->file('attachment')->store('service_requests', 'public'));
        }

        ServiceRequest::create($data);
        return redirect()->route('site.thank-you')->with('success', __('athar.form.success'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cv;
use App\Models\Job;
use Illuminate\Http\Request;

class AdminCvController extends Controller
{
    public function index(Request $request)
{
    $query = Cv::with('job')->orderBy('created_at', 'desc');

  
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


    $cvs = $query->paginate(20)->appends($request->only(['name', 'email', 'phone']));

    return view('admin.dashboard.cvs.index', compact('cvs'));
}


    public function destroy (Cv $cv)
    {
        $cv->delete();
        return back()->with('success', 'CV deleted');
    }

}
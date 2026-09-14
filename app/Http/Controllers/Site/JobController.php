<?php

namespace App\Http\Controllers\Site;

use App\Models\Job;
use App\Models\CareerCategory;
use App\Http\Controllers\Controller;
use App\Models\Cv;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with(['transNow', 'career_category.transNow'])->active()->orderBy('sort')->paginate(9);
        return view('site.pages.jobs.index', compact('jobs'));
    }

    public function show($slug)
    {
        $job = Job::with(['transNow', 'career_category.transNow'])->active()
            ->whereHas('trans', fn ($query) => $query->where('slug', $slug))
            ->firstOrFail();
        return view('site.pages.jobs.show', compact('job'));
    }

    public function apply(Request $request, $slug)
    {
        $job = Job::active()->whereHas('trans', fn ($query) => $query->where('slug', $slug))->firstOrFail();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);
        $data['job_id'] = $job->id;
        $data['cv_file'] = $request->file('cv')->store('cvs', 'public');
        unset($data['cv']);
        Cv::create($data);
        return back()->with('success', __('athar.form.success'));
    }
}

<?php

namespace App\Http\Livewire\Site;

use App\Models\Cv;
use App\Models\Job;
use Livewire\Component;
use Livewire\WithFileUploads;

class JobForm extends Component
{
    use WithFileUploads;

    public $jobId;
    public $name;
    public $email;
    public $phone;
    public $cv;
    public $message;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
        'message' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'name.required' => 'Full name is required',
        'email.required' => 'Email is required',
        'email.email' => 'Please enter a valid email',
        'phone.required' => 'Phone number is required',
        'cv.required' => 'Please upload your CV',
        'cv.mimes' => 'CV must be PDF or Word document',
        'cv.max' => 'CV must be less than 5MB',
    ];

    public function submit()
{
    $this->validate();

    // Upload CV
    $cvPath = $this->cv->store('cvs', 'public');

    // Save to database
    Cv::create([
        'job_id' => $this->jobId,
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'cv_file' => $cvPath,  
        'message' => $this->message,
    ]);

    // Reset form
    $this->reset(['name', 'email', 'phone', 'cv', 'message']);

    // Show success & close modal
    session()->flash('success', 'Application submitted successfully!');
    $this->dispatchBrowserEvent('close-apply-modal');
}

    public function render()
    {
        return view('livewire.site.job-form');
    }
}
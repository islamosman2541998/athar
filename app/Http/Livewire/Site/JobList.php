<?php

namespace App\Http\Livewire\Site;

use App\Models\Job;
use App\Models\CareerCategory;
use Livewire\Component;
use Livewire\WithPagination;

class JobList extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $category = '';
    public $employmentType = '';

    // Selected Job for Modals
    public $selectedJob = null;

    // Reset pagination when filters change
    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'employmentType' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingEmploymentType()
    {
        $this->resetPage();
    }

    // Select job for details modal
    public function showJobDetails($jobId)
    {
        $this->selectedJob = Job::with('transNow', 'career_category')->find($jobId);
        $this->dispatchBrowserEvent('open-job-modal');
    }

    // Select job for apply modal
    public function showApplyForm($jobId)
    {
        $this->selectedJob = Job::with('transNow')->find($jobId);
        $this->dispatchBrowserEvent('open-apply-modal');
    }

    public function render()
    {
        $jobs = Job::with(['transNow', 'career_category'])
            ->active()
            ->when($this->search, function ($query) {
                $query->whereHas('translations', function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->category, function ($query) {
                $query->where('career_category_id', $this->category);
            })
            ->when($this->employmentType, function ($query) {
                $query->where('employment_type', $this->employmentType);
            })
            ->orderBy('sort', 'ASC')
            ->paginate(9);

        $categories = CareerCategory::with('transNow')->get();

        $employmentTypes = [
            'Full time' => 'Full time',
            
        ];

        return view('livewire.site.job-list', compact('jobs', 'categories', 'employmentTypes'));
    }
}
<?php

namespace App\View\Components\Site\Doctors;

use App\Models\Doctor;
use Illuminate\View\Component;

class LoadMoreDoctors extends Component
{
    public $doctors;
    public $specialty_id, $start, $count;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($specialty_id, $start = 8, $count = 4)
    {
        $this->specialty_id = $specialty_id;
        $this->start = $start;
        $this->count = $count;
        
        $this->doctors = Doctor::with('trans')->where('specialty_id', $specialty_id)
        ->orderBy('sort', 'ASC')->active()->offset($start)->limit($count)->get();
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.doctors.load-more-doctors');
    }
}

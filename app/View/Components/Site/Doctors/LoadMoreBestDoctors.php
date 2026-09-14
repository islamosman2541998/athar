<?php

namespace App\View\Components\Site\Doctors;

use App\Models\Doctor;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class LoadMoreBestDoctors extends Component
{
    public $doctors;
    public $specialty_id, $start = 0, $count = 6;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($specialty_id, $start = 0, $count = 0)
    {
        
        $this->specialty_id = $specialty_id;
        
        $this->start = $start;
        $this->count = $count;

        if($specialty_id == 0){
            $this->doctors = Doctor::with('trans')->orderBy('sort', 'ASC')
            ->active()->offset($start)->limit($count)->get();
        }
        else{
            $this->doctors = Doctor::with('trans')->where('specialty_id', $this->specialty_id)
            ->orderBy('sort', 'ASC')->active()->offset($start)->limit($count)->get();
        }
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.doctors.load-more-best-doctors');
    }
}

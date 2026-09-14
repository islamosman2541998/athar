<?php

namespace App\View\Components\Site\Specialites;

use App\Models\Specialties;
use Illuminate\View\Component;

class LoadMoreSpecialites extends Component
{
    public $specialties;
    public $start, $count;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($start = 8, $count = 4)
    {
        $this->start = $start;
        $this->count = $count;
        
        $this->specialties = Specialties::with('trans')->orderBy('sort', 'ASC')
        ->active()->offset($start)->limit($count)->get();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.specialites.load-more-specialites');
    }
}

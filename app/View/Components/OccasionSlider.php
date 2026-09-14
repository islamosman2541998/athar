<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Occasion;

class OccasionSlider extends Component
{
    public $occasions;
    public $currentLang;

    /**
     * Create a new component instance.
     *
     * @param string 
     * @return void
     */
    public function __construct($currentLang = 'en')
    {
        $this->currentLang = $currentLang;
        $this->occasions = Occasion::with('transNow')->active()->orderBy('sort', 'ASC')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.occasion-slider');
    }
}
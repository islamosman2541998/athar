<?php

namespace App\View\Components\Site\Layouts;

use Illuminate\View\Component;

class Reviews extends Component
{
    public $reviews;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->reviews = Revie->with('trans')->orderBy('sort', 'ASC')->active()->feature()->limit(4)->get();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.layouts.reviews');
    }
}

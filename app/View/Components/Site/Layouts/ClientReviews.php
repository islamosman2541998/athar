<?php

namespace App\View\Components\Site\Layouts;

use App\Models\Reviews;
use Illuminate\View\Component;

class ClientReviews extends Component
{
    public $reviews;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->reviews = Reviews::with('trans')->orderBy('sort', 'ASC')->active()->feature()->limit(4)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.layouts.client-reviews');
    }
}

<?php

namespace App\View\Components\Site;

use App\Models\Gallery;
use Illuminate\View\Component;

class LoadMoreGallery extends Component
{
    public $galleries;
    public $start = 0, $count = 3;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($start = 0, $count = 3)
    {
        $this->start = $start;
        $this->count = $count;

        $this->galleries = Gallery::with('trans')->orderBy('sort', 'ASC')
        ->active()->offset($start)->limit($count)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.load-more-gallery');
    }
}

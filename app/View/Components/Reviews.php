<?php


namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Review;

class Reviews extends Component
{
    public $reviews;

    /**
     * Create a new component instance.
     *
     * @param int 
     * @return void
     */
    public function __construct($limit = 10)
    {
        $this->reviews = Review::active()->feature()
            ->with(['reviewable' => function ($query) {
                $query->with('transNow'); 
            }])
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
            // dd($this->reviews);

        if ($this->reviews->isEmpty()) {
            $this->reviews = collect();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.reviews');
    }
}
<?php



namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

use App\Models\Product;

class Offers extends Component
{
    public $offerProducts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($limit = 8)
    {
        $this->offerProducts = Product::active()
        ->where('best_offer', 1) 
        ->with(['transNow', 'rates'])
        ->limit(8)
        ->get();

        if ($this->offerProducts->isEmpty()) {
            $this->offerProducts = collect();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.offers');
    }
}

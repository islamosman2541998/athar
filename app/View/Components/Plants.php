<?php



namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;

class Plants extends Component
{
    public $plantProducts;

    /**
     * Create a new component instance.
     *
     * @param string|int 
     * @param int 
     * @return void
     */
    public function __construct($categoryIdOrSlug, $limit = 4)
    {
        $category = ProductCategory::active()
            ->where('id', $categoryIdOrSlug)
            ->orWhereHas('transNow', function ($query) use ($categoryIdOrSlug) {
                $query->where('slug', $categoryIdOrSlug);
            })
            ->first();

        if ($category) {
            $this->plantProducts = $category->productCategoriesProducts()
                ->active()
                ->with(['transNow', 'rates', 'orderDetails'])
                ->withCount(['orderDetails as total_sold' => function ($query) {
                    $query->select(DB::raw('SUM(quantity)'));
                }])
                ->orderByDesc('total_sold')
                ->take($limit)
                ->get();
        } else {
            $this->plantProducts = collect(); 
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.plants');
    }
}
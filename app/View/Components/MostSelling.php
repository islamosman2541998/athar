<?php



namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;
use Illuminate\Support\Facades\DB;



class MostSelling extends Component
{
    public $mostSellingProducts;

    public function __construct()
    {
        $this->mostSellingProducts = Product::active()
        ->with(['transNow', 'rates'])
        ->where('most_selling', 1) 
        ->get();
    }

    public function render()
    {
        return view('components.mostselling');
    }
}
<?php

namespace App\Http\Livewire\Site\Products;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public $categories, $products;
    public $selectedCategory = 0;

    public function mount($categories){
        $this->categories = $categories;
        $this->products = Product::with('transNow')->active()->get();
    }

    public function changeCategory($id){
        $this->selectedCategory = $id;
        if($id == 0){
            $this->products = Product::with('transNow')->active()->orderBy('sort', 'ASC')->get();
        }
        else{
            $this->products = Product::with('transNow')->active()->orderBy('sort', 'ASC')->whereHas('categories', function ($query) use ($id) {
                $query->where('product_categories.id', $id);
            })->get();
        }
    }

    public function render()
    {
        return view('livewire.site.products.index');
    }
}

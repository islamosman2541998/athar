<?php

namespace App\Http\Livewire;



use App\Models\Product;
use Livewire\Component;
use App\Models\ProductCategory;

class CategoryFilter extends Component
{
    public $selectedCategory = null;

  

    public function render()
    {
        $categories = ProductCategory::with('transNow')->get();
        $productsQuery = Product::with(['transNow', 'productCategoriesProducts']);
        
        if ($this->selectedCategory) {
            $productsQuery->whereHas('productCategoriesProducts', function ($query) {
                $query->where('product_category_id', $this->selectedCategory);
            });
        }
    
        $products = $productsQuery->get();
    
        return view('livewire.category-filter', compact('categories', 'products'));
    }


    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        dd($this->selectedCategory);
    }



}

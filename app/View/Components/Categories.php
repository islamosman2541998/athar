<?php

namespace App\View\Components;
use App\Models\ProductCategory;

use Illuminate\View\Component;

class Categories extends Component
{

    public $categories;
    public $currentLang;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $currentLang = 'en')
    {
        $this->currentLang = $currentLang;
        $this->categories = ProductCategory::with(['transNow', 'products' => function ($query) {
            $query->where('status', 1)
                  ->whereHas('trans', function ($q) {
                      $q->where('locale', app()->getLocale());
                  })
                  ->with('transNow');
        }])
        ->active()  
        ->feature() 
        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.categories');
       
    
    }
}
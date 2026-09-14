<?php

namespace App\Http\Livewire\Site;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\Product;
use App\Models\Occasion;
use App\Models\ProductCategory;
use App\Models\Filter;

class SearchLive extends Component
{
    public $query = '';
   protected Collection $results;

    public function mount()
    {
        $this->results = collect();
    }

public function updatedQuery()
{
    $raw = trim($this->query);

    if ($raw === '') {
        $this->results = collect();
        return;
    }

    
    $q = str_replace(['أ','إ','آ'], 'ا', $raw);

    $categories = ProductCategory::active()
        ->whereHas('translations', function($qb) use ($q) {
            $qb->whereRaw(
                "REPLACE(REPLACE(REPLACE(title, 'أ','ا'), 'إ','ا'), 'آ','ا') LIKE ?",
                ["{$q}%"]
            );
        })
        ->get()
        ->each(fn($m) => $m->search_type = 'category');

    $occasions = Occasion::active()
        ->whereHas('translations', function($qb) use ($q) {
            $qb->whereRaw(
                "REPLACE(REPLACE(REPLACE(title, 'أ','ا'), 'إ','ا'), 'آ','ا') LIKE ?",
                ["{$q}%"]
            );
        })
        ->get()
        ->each(fn($m) => $m->search_type = 'occasion');

    $filterIds = Filter::whereHas('translations', function($qb) use ($q) {
        $qb->whereRaw(
            "REPLACE(REPLACE(REPLACE(name, 'أ','ا'), 'إ','ا'), 'آ','ا') LIKE ?",
            ["{$q}%"]
        );
    })->pluck('id');

    
    $productQuery = Product::active()
        ->where(function($pqb) use ($q, $raw) {
            
            $pqb->whereHas('translations', function($qb) use ($q) {
                $qb->whereRaw(
                    "REPLACE(REPLACE(REPLACE(title, 'أ','ا'), 'إ','ا'), 'آ','ا') LIKE ?",
                    ["{$q}%"]
                )->orWhereRaw(
                    "REPLACE(REPLACE(REPLACE(description, 'أ','ا'), 'إ','ا'), 'آ','ا') LIKE ?",
                    ["%{$q}%"]
                );
            });

            
            $pqb->orWhere('code', 'like', "%{$raw}%");
        });

    if ($filterIds->isNotEmpty()) {

        $productQuery->orWhereHas('filters', fn($qb) => $qb->whereIn('filters.id', $filterIds));
    }

    $products = $productQuery
        ->get()
        ->each(fn($m) => $m->search_type = 'product');

    $this->results = $categories
        ->merge($occasions)
        ->merge($products)
        ->sortByDesc(fn($m) => $m->created_at ?? now())
        ->values();
}



     public function redirectToShop()
    {
        return redirect()->route('site.shop', [
            'search' => $this->query,
        ]);
    }

   public function render()
{
    $results = $this->results; 

    return view('livewire.site.search-live', compact('results'));
}
}

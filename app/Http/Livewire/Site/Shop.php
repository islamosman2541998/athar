<?php

namespace App\Http\Livewire\Site;

use App\Models\Cart;
use App\Models\Filter;
use App\Models\Product;
use Livewire\Component;
use App\Models\Occasion;
use App\Models\CartGroup;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Cookie;

class Shop extends Component
{
    // preserve existing query string bindings
    protected $queryString = [
        'search'          => ['except' => ''],
        'filterCategory'  => ['except' => []],
        'filterOccasion'  => ['except' => []],
        'filterAttribute' => ['except' => []],
        'sortfilters'     => ['except' => ''],
        'sort'            => ['except' => ''],
        'filter'          => ['except' => ''],
        'currentMin'      => ['except' => null],
        'currentMax'      => ['except' => null],
        'sale'             => ['except' => 0],
    ];

    // Filters & settings
    public $categories;
    public $occasions;
    public $parents;
    public $sale = 0;
    public $filterCategory   = [];
    public $filterOccasion   = [];
    public $filterAttribute  = [];
    public $sortfilters      = '';
    public $sort             = '';
    public $filter           = '';
    public $minPrice;
    public $maxPrice;
    public $currentMin;
    public $currentMax;
    public $search = '';

    // Infinite‐scroll state
    public int $currentPage = 1;
    public int $perPage     = 15;
    public EloquentCollection $allProducts;
    public bool $hasMore = true;

    // Cart modal state
    public $show_modal = false;
    public $quantity   = 1;

    public function mount()
    {
        $this->search = request()->query('search', '');
        $this->sale = (int) request()->query('sale', 0);

        // 1) Initialize empty collection:
        $this->allProducts = new EloquentCollection();

        // 2) Price bounds
        $this->minPrice   = Product::min('price');
        $this->maxPrice   = Product::max('price');
        $this->currentMin = $this->minPrice;
        $this->currentMax = $this->maxPrice;

        // 3) Load sidebar filters
        $this->categories = ProductCategory::active()->feature()
            ->with([ 'transNow', 'products' => fn($q) =>
                $q->where('status', 1)->whereHas('trans', fn($t) => $t->where('locale', app()->getLocale()))])
            ->get();
        $this->occasions = Occasion::with('transNow', 'products')->get();
        $this->parents    = Filter::with( 'transNow', 'children', 'children.transNow')->whereNull('parent_id')->get();

        // 4) Read query parameters into filters/sorts
        if ($c = request()->query('category_id'))  $this->filterCategory[$c]  = true;
        if ($o = request()->query('occasion_id'))  $this->filterOccasion[$o]  = true;
        $this->sort        = request()->query('sort', '');
        $this->filter      = request()->query('filter', '');
        $this->sortfilters = request()->query('sortfilters', '');

        // 5) Load first batch
        $this->loadProducts();
    }

   protected function getFilteredBaseQuery()
{
    $locale = app()->getLocale();
    $q = Product::with('transNow')
        ->where('status', 1)
        ->where('product_cart', 0)
        ->where('show_in_cart', 0)
        ->when($this->search, function ($q) use ($locale) {
            $search = "%{$this->search}%";
            $q->where(function ($q2) use ($search) {
                $q2->where('product_translations.title', 'LIKE', $search)
                   ->orWhere('product_translations.description', 'LIKE', $search);
            });
        });

    if ($ids = array_keys(array_filter($this->filterCategory))) {
        $q->whereHas('productCategoriesProducts', fn($t) => $t->whereIn('product_category_id', $ids));
    }
    if ($ids = array_keys(array_filter($this->filterOccasion))) {
        $q->whereHas('occasions', fn($t) => $t->whereIn('occassions.id', $ids));
    }
    if ($ids = array_keys(array_filter($this->filterAttribute))) {
        $q->whereHas('filters', fn($t) => $t->whereIn('filters.id', $ids));
    }

    if ($this->sort === 'most_selling') {
        $q->where('most_selling', 1);
    }
    if ($this->sort === 'best_offer') {
        $q->where('best_offer', 1);
    }
    if ($this->filter) {
        $q->where($this->filter, 1);
    }
    if ($this->sale === 1) {
        $q->where('sale', '>', 0);
    }

    match ($this->sortfilters) {
        'Price: High to Low' => $q->orderBy('price', 'desc'),
        'Price: Low to High' => $q->orderBy('price', 'asc'),
        'Latest Arrival'     => $q->orderBy('created_at', 'desc'),
        default              => null,
    };

    $q->whereBetween('price', [$this->currentMin, $this->currentMax]);

    return $q;
}
public function updatedSearch()
{
    $this->resetInfinite();
}

    public function loadProducts()
    {
        $batch = $this->getFilteredBaseQuery()
            ->skip(($this->currentPage - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();

        // if fewer than perPage, no more batches
        if ($batch->count() < $this->perPage) {
            $this->hasMore = false;
        }

        // merge into the collection
        $this->allProducts = $this->allProducts->merge($batch);
    }

    public function loadMore()
    {
        if (! $this->hasMore) return;
        $this->currentPage++;
        $this->loadProducts();
    }

    protected function resetInfinite()
    {
        // clear everything and reload first batch
        $this->allProducts  = new EloquentCollection();
        $this->currentPage  = 1;
        $this->hasMore      = true;
        $this->loadProducts();
    }

    // Watchers to re‐load when filter or sort changes:
    public function updatedFilterCategory()
    {
        $this->resetInfinite();
    }
    public function updatedFilterOccasion()
    {
        $this->resetInfinite();
    }
    public function updatedFilterAttribute()
    {
        $this->resetInfinite();
    }
    public function updatedsortfilters()
    {
        $this->resetInfinite();
    }
    public function updatedSort()
    {
        $this->resetInfinite();
    }
    public function updatedFilter()
    {
        $this->resetInfinite();
    }
    public function updatedCurrentMin()
    {
        $this->resetInfinite();
    }
    public function updatedCurrentMax()
    {
        $this->resetInfinite();
    }

    public function setsortfilters(string $type)
    {
        $this->sortfilters = $type;
        $this->resetInfinite();
    }

    public function addToCart($productId)
    {
        $product = Product::with('transNow')->findOrFail($productId);


        $unitPrice = ($product->price_after_sale !== null && $product->price_after_sale < $product->price)
            ? $product->price_after_sale
            : $product->price;

        $qty  = $this->quantity;
        $cook = Cookie::get('cart_cookie') ?: Str::uuid()->toString();
        Cookie::queue('cart_cookie', $cook, 60 * 24 * 30);

        $group = CartGroup::firstOrCreate(['cookeries' => $cook]);

        $cart = Cart::firstOrNew([
            'cart_group_id' => $group->id,
            'product_id'    => $product->id,
        ]);

        $cart->product_name = $product->transNow->title;
        $cart->quantity    += $qty;

        $cart->price       = $unitPrice;

        $cart->total_price = $cart->quantity * $unitPrice;

        $cart->cookeries = $cook;
        $cart->save();

        $count = Cart::where('cart_group_id', $group->id)->sum('quantity');
        $this->emit('cartCountUpdated', $count);

        $this->show_modal = true;
    }


    public function closeModal()
    {
        $this->show_modal = false;
    }

    public function render()
    {
        return view('livewire.site.shop', [
            'products' => $this->allProducts,
            'hasMore'  => $this->hasMore,
        ]);
    }
}

<?php


namespace App\Http\Livewire\Site;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Component;
use App\Models\CartGroup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class ProductShow extends Component
{
    public $product;
    public $userInput = '';
    public $show_modal = false;
    public $similarProducts;
    public $averageRating = 0;
    public $reviewCount = 0;
    public $selectedPocket;
    public $pockets;

    public $productsShowInCart;
    

    public function mount(Product $product)
    {

      
        
    $this->product = $product;
   
    $categoryIds = $product
        ->productCategoriesProducts()        
        ->pluck('product_category_id')       
        ->toArray();

    $this->similarProducts = Product::active()
        ->where('id', '!=', $product->id)
        ->whereHas('productCategoriesProducts', function($q) use($categoryIds) {
            $q->whereIn('product_category_id', $categoryIds);
        })
        ->where('show_in_cart', 0)
        ->where('product_cart', 0)
        ->with(['transNow', 'rates'])
        ->inRandomOrder()
        ->get();
        $this->productsShowInCart = Product::active()
            ->showincart()
            ->with('transNow')
            ->get();
        if ($product->has_pockets && $product->pockets->isNotEmpty()) {
            $this->selectedPocket = $product->pockets->first()->id;
        }

        // $this->averageRating = $product->rates()->avg('rating_value') ?? 0;
        // $this->reviewCount = $product->rates()->count();
        // $ratingDistribution = $product->rates()
        //     ->select('rating_value', DB::raw('count(*) as count'))
        //     ->groupBy('rating_value')
        //     ->pluck('count', 'rating_value')
        //     ->toArray();
        // $totalReviews = array_sum($ratingDistribution);
        // $percentages = [];
        // for ($i = 1; $i <= 5; $i++) {
        //     $count = $ratingDistribution[$i] ?? 0;
        //     $percentages[$i] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        // }

        // $this->product = $product;
    }



    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->price_after_sale !== null && $product->price_after_sale < $product->price) {
            $basePrice = $product->price_after_sale;
        } else {
            $basePrice = $product->price;
        }

        $pocketId = null;
        if ($productId == $this->product->id && $this->selectedPocket) {
            $pocket = $product->pockets()->find($this->selectedPocket);
            if ($pocket) {
                $basePrice = $pocket->price;
                $pocketId  = $pocket->id;
            }
        }

        $userInput = trim($this->userInput ?? '');

        $trimmed   = preg_replace('/\s+/', '', $userInput);
        $length    = mb_strlen($trimmed);
        $priceToUse = ($length > 0)
            ? $length * $basePrice
            : $basePrice;

        $cookeries = Cookie::get('cart_cookie');
        if (! $cookeries) {
            $cookeries = Str::uuid()->toString();
            Cookie::queue('cart_cookie', $cookeries, 60 * 24 * 30);
        }
        $cartGroup = CartGroup::firstOrCreate(['cookeries' => $cookeries]);

        $cart = Cart::firstOrNew([
            'cart_group_id' => $cartGroup->id,
            'product_id'    => $product->id,
            'pocket_id'     => $pocketId,
        ]);

        $cart->product_name  = $product->transNow->title;
        $cart->quantity      = 1;
        $cart->price         = $priceToUse;
        $cart->total_price   = $priceToUse;
        $cart->cookeries     = $cookeries;
        $cart->user_input    = $userInput;
        $cart->save();

        $cartCount = Cart::where('cart_group_id', $cartGroup->id)->sum('quantity');
        $this->emit('cartCountUpdated', $cartCount);
        $this->show_modal = true;
    }



    public function closeModal()
    {
        $this->show_modal = false;
    }

    public function orderNow()
    {
        $this->addToCart($this->product->id);
        return redirect()->route('site.checkout');
    }
    public function getCurrentPriceProperty()
    {
        // if ($this->selectedPocket && $this->product->has_pockets) {
        //     $pocket = $this->product->pockets()->find($this->selectedPocket);
        //     return $pocket ? $pocket->price : $this->product->price;
        // }
        // return $this->product->price;

        if ($this->selectedPocket && $this->product->has_pockets) {
            $pocket = $this->product->pockets()->find($this->selectedPocket);
            return $pocket ? $pocket->price : $this->product->price;
        }

        return $this->product->price;
    }
     public function getCurrentImageProperty()
    {
        if ($this->selectedPocket) {
            $pocket = $this->product->pockets->firstWhere('id', $this->selectedPocket);
            if ($pocket && $pocket->image) {
                return asset("attachments/pockets/{$pocket->image}");
            }
        }
        return asset($this->product->pathInView());
    }
    public function updatedSelectedPocket()
{
    $this->dispatchBrowserEvent('selectedPocketChanged');
}

    public function render()
    {
        return view('livewire.site.product-show', [
            'product' => $this->product,
            'similarProducts' => $this->similarProducts,
            'show_modal' => $this->show_modal,
            'averageRating' => $this->averageRating,
            'productsShowInCart'   => $this->productsShowInCart,
            'currentPrice'      => $this->currentPrice,
            'currentImage'      => $this->currentImage,
            

        ]);
    }
}

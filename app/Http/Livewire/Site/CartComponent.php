<?php

namespace App\Http\Livewire\Site;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Component;
use App\Models\CartGroup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CartComponent extends Component
{
    public $carts;
    public $total = 0;
    public $userInputs = [];
    public $userInput = '';
    public $productsShowInCart;


    public function mount()
    {
        $this->loadCart();
        $this->productsShowInCart = Product::active()
            ->showincart()
            ->with('transNow')
            ->get();
    }

    public function loadCart()
    {

        $cookeries = Cookie::get('cart_cookie');
        if ($cookeries) {
            $cartGroup = CartGroup::where('cookeries', $cookeries)->first();
            if ($cartGroup) {
                $this->carts = Cart::with(['product', 'pocket'])
                    ->where('cart_group_id', $cartGroup->id)
                    ->get();
                $this->calculateTotal();
                return;
            }
        }
        $this->carts = collect();
        $this->total = 0;
    }

    public function increaseQuantity($cartId)
    {
        $cart = Cart::findOrFail($cartId);

        if ($cart->user_input) {
            $originalText = $cart->original_input ?: $cart->user_input;

            $cleanOriginal = preg_replace('/\s+/', '', $originalText);

            $lastChar = mb_substr($cleanOriginal, -1, 1);

            $newInput = $cart->user_input . $lastChar;

            $newLen = mb_strlen(preg_replace('/\s+/', '', $newInput));

            $basePrice = $this->resolveBasePrice($cart);
            $newPrice = $newLen * $basePrice;

            $cart->update([
                'user_input' => $newInput,
                'quantity' => $newLen,
                'price' => $newPrice,
                'total_price' => $newPrice
            ]);
        } else {
            $cart->update([
                'quantity' => $cart->quantity + 1,
                'total_price' => $cart->price * ($cart->quantity + 1)
            ]);
        }

        $this->loadCart();
        $this->emit('cartCountUpdated', $this->getCartItemCount());
    }
    public function decreaseQuantity($cartId)
    {
        $cart = Cart::findOrFail($cartId);

        if ($cart->user_input) {
            $trimmed    = preg_replace('/\s+/', '', $cart->user_input);
            $currentLen = mb_strlen($trimmed);

            if ($currentLen > 1) {
                $newLen   = $currentLen - 1;
                $newInput = mb_substr($trimmed, 0, $newLen);

                $cart->user_input   = $newInput;
                $cart->quantity     = $newLen;

                $basePrice          = $this->resolveBasePrice($cart);
                $cart->price        = $newLen * $basePrice;
                $cart->total_price  = $newLen * $basePrice;
                $cart->save();
            }
        } else {
            if ($cart->quantity > 1) {
                $cart->quantity    -= 1;
                $cart->total_price = $cart->quantity * $cart->price;
                $cart->save();
            }
        }

        $this->loadCart();
        $this->emit('cartCountUpdated', $this->getCartItemCount());
    }



    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = 1;
        $price = ($product->price_after_sale !== null && $product->price_after_sale < $product->price)
            ? $product->price_after_sale
            : $product->price;
        $name  = $product->transNow->title;

        $cookeries = Cookie::get('cart_cookie');
        if (!$cookeries) {
            $cookeries = Str::uuid()->toString();
            Cookie::queue('cart_cookie', $cookeries, 60 * 24 * 30);
        }

        $cartGroup = CartGroup::firstOrCreate(['cookeries' => $cookeries]);

        $cart = Cart::firstOrNew([
            'cart_group_id' => $cartGroup->id,
            'product_id'    => $product->id,
        ]);
        $cart->product_name = $name;
        $cart->quantity    += $quantity;
        $cart->price        = $price;
        $cart->total_price  = $cart->quantity * $price;
        $cart->cookeries    = $cookeries;

        if (! $cart->exists) {
            $cart->original_input = $this->userInput;
        }

        $cart->user_input = $this->userInput;

        $trimmed    = preg_replace('/\s+/', '', $this->userInput);
        $length     = mb_strlen($trimmed);
        $cart->quantity = $length > 0 ? $length : 1;

        $cart->save();

        $this->loadCart();

        $itemCount = $this->getCartItemCount();

        $this->emit('cartCountUpdated', $itemCount);
    }
    protected function resolveBasePrice(Cart $cart): float
    {
        $p = $cart->product;
        $base = ($p->price_after_sale && $p->price_after_sale < $p->price)
            ? $p->price_after_sale
            : $p->price;
        if ($cart->pocket) {
            $base = $cart->pocket->price;
        }
        return $base;
    }
    protected function getCartItemCount(): int
    {
        return $this->carts->sum('quantity');
    }

    public function calculateTotal()
    {
        $this->total = $this->carts->sum('total_price');
    }

    public function render()
    {
        return view(
            'livewire.site.cart-component',
            [
                'productsCart' => $this->carts,
                'total'        => $this->total,
                'productsShowInCart'   => $this->productsShowInCart,
            ]
        );
    }
}

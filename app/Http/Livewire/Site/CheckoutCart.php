<?php

namespace App\Http\Livewire\Site;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartGroup;
use Illuminate\Support\Facades\Cookie;

class CheckoutCart extends Component
{
    public $carts;
    public $subtotal;
    public $shippingCost = 548.00;
    public $taxRate = 0.15;
    public $taxAmount;
    public $finalTotal;

    protected $listeners = ['refreshCart' => 'refresh'];

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $cookeries = Cookie::get('cart_cookie');
        $cartGroup = CartGroup::where('cookeries', $cookeries)->first();
        $this->carts = $cartGroup ? Cart::with('product')->where('cart_group_id', $cartGroup->id)->get() : collect();
        $this->calculateTotals();
    }

    public function increment($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->update([
            'quantity' => $cart->quantity + 1,
            'total_price' => ($cart->quantity + 1) * $cart->price
        ]);
        $this->refresh();
        $this->emit('cartUpdatedExternally');

    }

    public function decrement($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        if ($cart->quantity > 1) {
            $cart->update([
                'quantity' => $cart->quantity - 1,
                'total_price' => ($cart->quantity - 1) * $cart->price
            ]);
            $this->refresh();
            $this->emit('cartUpdatedExternally');

        }
    }

    public function remove($cartId)
    {
        Cart::findOrFail($cartId)->delete();
        $this->refresh();
        $this->emit('cartUpdatedExternally');

    }

    private function calculateTotals()
    {
        $this->subtotal = $this->carts->sum('total_price');
        $this->taxAmount = ($this->subtotal + $this->shippingCost) * $this->taxRate;
        $this->finalTotal = $this->subtotal + $this->shippingCost + $this->taxAmount;
    }

    public function render()
    {
        return view('livewire.site.checkout-cart');}
}

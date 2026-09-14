<?php

namespace App\Http\Livewire\Site;

use App\Models\Cart;
use App\Models\CartGroup;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class CartIcon extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartCountUpdated' => 'updateCartCount', 'cartUpdatedExternally' => 'refreshCartCount' ];


    public function mount()
    {
        $cookeries = Cookie::get('cart_cookie');
        $this->cartCount = Cart::where('cookeries', $cookeries)->sum('quantity');
    }

    public function updateCartCount($count)
    {
        $this->cartCount = $count;
    }
    
    public function refreshCartCount()
{
    $cookeries = Cookie::get('cart_cookie');
    if ($cookeries) {
        $cartGroup = CartGroup::where('cookeries', $cookeries)->first();
        if ($cartGroup) {
            $this->cartCount = Cart::where('cart_group_id', $cartGroup->id)->sum('quantity');
        }
    }
}


    public function render()
    {
        return view('livewire.site.cart-icon');
    }
}
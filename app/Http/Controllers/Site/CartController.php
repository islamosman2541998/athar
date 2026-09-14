<?php

namespace App\Http\Controllers\Site;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartGroup;
use App\Models\ProductPocket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $cookeries = Cookie::get('cart_cookie');
        $carts = collect();
        $total = 0;

        if ($cookeries) {
            $cartGroup = CartGroup::where('cookeries', $cookeries)->first();
            if ($cartGroup) {
                $carts = Cart::with(['product', 'pocket'])
                    ->where('cart_group_id', $cartGroup->id)
                    ->get();
                $total = $carts->sum('total_price');
            }
        }

        $cartCount = $carts->sum('quantity');
        session()->put('cart_count', $cartCount);

        return view('site.pages.cart', compact('carts', 'total'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::with('transNow')->findOrFail($productId);
        $quantity = $request->input('quantity', 1);
        $pocketId = $request->input('pocket_id');
        $price = $product->price;

        if ($pocketId) {
            $pocket = ProductPocket::find($pocketId);
            if ($pocket) {
                $price += $pocket->price; 
            }
        }

        $cookeries = Cookie::get('cart_cookie');
        if (!$cookeries) {
            $cookeries = Str::uuid()->toString();
            Cookie::queue('cart_cookie', $cookeries, 60 * 24 * 30);
        }

        $cartGroup = CartGroup::firstOrCreate(['cookeries' => $cookeries]);

        $cart = Cart::firstOrNew([
            'cart_group_id' => $cartGroup->id,
            'product_id' => $product->id,
            'pocket_id' => $pocketId
        ]);

        $cart->product_name = $product->transNow->title;
        $cart->quantity += $quantity;
        $cart->price = $price;
        $cart->total_price = $cart->quantity * $price;
        $cart->cookeries = $cookeries;
        $cart->save();

        $cartCount = Cart::where('cart_group_id', $cartGroup->id)->sum('quantity');
        session()->put('cart_count', $cartCount);

        return redirect()->route('site.cart');
    }

    public function destroy(Cart $cart)
    {
        $cookeries = Cookie::get('cart_cookie');
        $cartGroup = CartGroup::where('cookeries', $cookeries)->first();

        if (!$cartGroup || $cart->cart_group_id !== $cartGroup->id) {
            abort(403, 'Unauthorized');
        }

        $cart->delete();
        return back();
    }
}
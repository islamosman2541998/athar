<?php

namespace App\Repository;


use App\Models\Cart;
use App\RepositoryInterface\TestCartRepositoryInterface;
use App\Traits\cartTrait;
use Illuminate\Support\Str;

//use App\Charity\Carts\CartInterface;
//use App\Models\CharityProject;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class DBTestCartRepository implements TestCartRepositoryInterface
{
    use cartTrait;


    /**
     * add item too cart
     *
     * @param Product $item
     * @param int $quantity
     * @param int $price
     * @param null $giftIfo
     * @param bool $new
     * @return array
     */
    public function addItem(Product $item, $quantity = 1, $price = 0, $attributes, $giftIfo = NULL, $new = false)
    {
        //validate donation price:
        if ($quantity <= 0) {
            return [
                'type' => 'warning',
                'value' => __('The donation value must be greater than zero'),
            ];
        }

        $cookieValue = Cookie::get('cart');

        if (! $this->checkCookie($attributes)['exists']) {

            $token = Str::random(32); // Adjust the length as needed
//            $cookieValue = Cookie::make('cart', $token, 60 * 24 * 365);
//            $cookieValue =   Cookie::queue(Cookie::make('cart' , '1.0' , 0.1));
            $cookieValue = $this->setCookie($attributes);
dd($this->checkCookie($attributes)['exists']);
        }

        return response()->json(  Cookie::has('cart'));
        if (!$new) {
            // check if item in the cart
            $cart = Cart::where('cookeries', $cookieValue)
//                ->where('item_name', $item->getItemName())
//                ->where('item_type', $item->getType())
//                ->where('item_id', $item->getItemId())
//                ->where('item_sub_type', $item->getDonationType())
                ->where('product_id', $attributes['product_id'])
                ->where('product_name', $attributes['product_name'])
                ->where('price', $price)->get()->first();
        } else {
            $cart = "";
        }
        // if($item->getType() == CharityProject::class){
        // dd( $this->getVendor( $item->getType(), $item->getItemId() ) );

        if (!$cart) {  // create item
            $cart = Cart::create([
                'product_id' => $attributes['product_id'] ?? null,
                'product_name' =>  $attributes['product_name'] ?? null,
                'cookeries' => $cookieValue,
                'quantity' => $quantity,
                'price' => $price,
                'user_id' => auth()->id ?? null,
            ]);
        } else {  // update item
            $cart->quantity = $cart->quantity + $quantity;
//            $cart->gift_details = $giftIfo;
            $cart->save();
        }

        return
        $message = [
            'card_id' => $cart->id,
            'type' => 'success',
            'value' => trans('The project has been successfully added to the donation basket')
        ];
        return $cookieValue;
        // }

        return $message;
    }

    public function addGivtenCard($card_id, $data)
    {
        $cart = Cart::find($card_id);
        $cart->givten_details = json_encode($data);
        $cart->save();
        return 1;
    }

    /**
     * Adds gift card details to the specified cart item.
     */
    public function addGiftCard($card_id, $data)
    {
        $cart = Cart::find($card_id);
        $cart->gift_card_details = json_encode($data);
        $cart->save();
        return 1;
    }

    public function addProjectToCard($card_id, $data)
    {
        $cart = Cart::find($card_id);
        $cart->gift_projects_details = json_encode($data);
        $cart->save();
        return 1;
    }

    public function addProductCard($card_id, $data)
    {
        return Cart::find($card_id)->update('gift_products_details', $data);
    }

    public function addProjectCard($card_id, $data)
    {
        return Cart::find($card_id)->update('gift_projects_details', $data);
    }

    /**
     * conect project to product
     */
    public function connectProjectToProduct($main_id, $sub_id)
    {
        $cart = Cart::find($sub_id);
        $cart->cart_id = $main_id;
        $cart->save();
        return 1;
    }

    public function getItems()
    {
        $cookieValue = Cookie::get('cart');
        return Cart::with(['item', 'item.trans'])->where('cookeries', $cookieValue)->get();
    }

    public function getItemsWithInfo()
    {
        $cookieValue = Cookie::get('cart');
        $cart = Cart::with('item', 'item.trans')->where('cookeries', $cookieValue);
        return [
            'cart' => clone $cart->get(),
            'total' => $cart->selectRaw('SUM(price * quantity) as total')->value('total'),
            'quantity' => $cart->sum('quantity'),
        ];
    }

    public function removeItem($cartID)
    {
        $cart = Cart::find($cartID);
        $cart->delete();
    }

    public function emptyFunc()
    {
        $cookieValue = Cookie::get('cart');
        Cart::where('cookeries', $cookieValue)->delete();
    }

    public function minusItem($id)
    {
        $cart = Cart::find($id);
        if ($cart->quantity > 1) {
            $cart->quantity = $cart->quantity - 1;
            $cart->save();
        }
    }

    public function plusItem($id)
    {
        $cart = Cart::find($id);
        $cart->quantity = $cart->quantity + 1;
        $cart->save();
    }


    public function updateQuantity($productId, $quantity)
    {
    }


    public function getTotalItems()
    {
    }

    public function getTotalPrice()
    {
    }


    public function getVendor($type, $id)
    {
        if ($type == Product::class) {
            return Product::find($id)->vendor_id;
        }
        return null;
    }


    public function updateDonor()
    {
        $cookieValue = Cookie::get('cart');
        $donor_id = @auth('account')->user() ?->donor->id;
        $cart = Cart::where('cookeries', $cookieValue)->update(['donor_id' => $donor_id]);
        return $cart;
    }
}

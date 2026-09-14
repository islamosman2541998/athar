<?php


namespace App\RepositoryInterface;

use App\Models\Product;

interface TestCartRepositoryInterface
{
    /**
     * Add an item to the cart.
     *
     * @param Product $product
     * @param int $quantity
     * @param int $price
     * @param string $giftInfo
     *
     * @return array|message
     */
    public function addItem(Product $product, $quantity = 1, $price = 1 , $attributes);

    /**
     * get all items from the cart.
     * @return array|CartItem
     */
    public function getItems();

    /**
     * remove item from the cart.
     *
     * @param string|int $itemId
     * @return null
     */
    public function removeItem($itemId);


    /**
     * empty all items from the cart.
     *
     * @return null
     */
    public function emptyFunc();

    /**
     * minus item quantity from the cart.
     *
     * @param string|int $itemId
     * @return null
     */
    public function minusItem($itemId);

    /**
     * plus item quantity from the cart.
     *
     * @param string|int $itemId
     * @return null
     */
    public function plusItem($itemId);

    // public function updateQuantity($itemId, $quantity);

    // public function getTotalItems();

    // public function getTotalPrice();
//
}

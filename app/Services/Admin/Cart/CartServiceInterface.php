<?php

namespace App\Services\Admin\Cart;


interface CartServiceInterface
{
    public function getCartItems($userId);
    public function addToCart(array $data);
    public function updateCartItem(array $data);
    public function deleteCartItem($userId, $cartItemId);
    public function clearCart($userId);
}


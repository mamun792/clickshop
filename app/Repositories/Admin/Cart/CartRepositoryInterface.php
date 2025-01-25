<?php

namespace App\Repositories\Admin\Cart;

interface CartRepositoryInterface
{
    public function getCartItems($userId);
    public function addToCart(array $data);
    public function updateCartItem(array $data);
    public function deleteCartItem($userId, $cartItemId);
    public function clearCart($userId);
}
<?php

namespace App\Services\Admin\Cart;

use App\Repositories\Admin\Cart\CartRepositoryInterface;

class CartService implements CartServiceInterface
{
    protected $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getCartItems($userId)
    {
        return $this->cartRepository->getCartItems($userId);
    }

    public function addToCart(array $data)
    {
        return $this->cartRepository->addToCart($data);
    }

    public function updateCartItem(array $data)
    {
        return $this->cartRepository->updateCartItem($data);
    }

    public function deleteCartItem($userId, $cartItemId)
    {
        return $this->cartRepository->deleteCartItem($userId, $cartItemId);
    }

    public function clearCart($userId)
    {
        return $this->cartRepository->clearCart($userId);
    }

    
}

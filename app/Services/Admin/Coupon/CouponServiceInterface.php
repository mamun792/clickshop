<?php

namespace App\Services\Admin\Coupon;

use App\Models\Coupon;
use App\Models\Product;

interface CouponServiceInterface
{
    public function createCoupon(array $data);

    public function findByCode(string $code): ?Coupon;

    public function deleteCoupon(Coupon $coupon): void;

    public function updateCoupon(Coupon $coupon, array $data): void;

    public function allCoupons();

    public function findCoupon(int $id): Coupon;

    public function allProducts();

    public function addProduct(Coupon $coupon, array $productIds): bool;

    public function allProductsInCoupon();
}
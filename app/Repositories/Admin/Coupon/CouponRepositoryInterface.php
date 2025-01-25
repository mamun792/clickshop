<?php

namespace App\Repositories\Admin\Coupon;

use App\Models\Coupon;
use App\Models\Product;
// use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface CouponRepositoryInterface
{
    public function create(array $data): Coupon;
    public function findByCode(string $code): ?Coupon;
     public function addProduct(Coupon $coupon, array $productIds): void;
    // public function removeProduct(Coupon $coupon, Product $product): void;
    public function delete(Coupon $coupon): void;
    public function update(Coupon $coupon, array $data): void;
    public function all(): Collection;
    public function find(int $id): Coupon;

    public function allProducts(): Collection;

    public function couponProducts(Coupon $coupon): Collection;

    public function allProductsInCoupon(): Collection;
   
}

<?php

namespace App\Repositories\Admin\Coupon;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class CouponRepository implements CouponRepositoryInterface
{
    public function create(array $data): Coupon
    {
        return Coupon::create($data);
    }

    public function findByCode(string $code): ?Coupon
    {
        return Coupon::where('code', $code)->first();
    }

    public function delete(Coupon $coupon): void
    {
        $coupon->delete();
    }

    public function update(Coupon $coupon, array $data): void
    {
        $coupon->update($data);
    }

    public function all(): Collection
    {
        return Coupon::all();
    }

    public function find(int $id): Coupon
    {
        return Coupon::findOrFail($id);
    }

    public function allProducts(): Collection
    {
        return Product::latest()->get();
    }

    public function couponProducts(Coupon $coupon): Collection
    {
        return $coupon->products;
    }

    public function addProduct(Coupon $coupon, array $productIds): void
    {
        $couponId = $coupon->id;
        $coupon = Coupon::findOrFail($couponId);
        $timestamp = now();

        // // Attach products with pivot data (timestamps)
        // $coupon->products()->attach($productIds, [
        //     'created_at' => $timestamp,
        //     'updated_at' => $timestamp,
        // ]);
        $coupon->products()->syncWithoutDetaching(
            array_map(function ($productId) use ($timestamp) {
                return [
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }, $productIds)
        );
    }

    public function allProductsInCoupon(): Collection
    {
      return  $coupons = Coupon::with('products')->get();

       
      
    }

   

}

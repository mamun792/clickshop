<?php

namespace App\Services\Admin\Coupon;

use App\Models\Coupon;
use App\Models\Product;
use App\Repositories\Admin\Coupon\CouponRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CouponService implements CouponServiceInterface
{
    protected $couponRepository;
   

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
      
    }

    public function createCoupon(array $data)
    {
       return $this->couponRepository->create($data);

    }

    public function findByCode(string $code): ?Coupon
    {
        return $this->couponRepository->findByCode($code);
    }

    public function deleteCoupon(Coupon $coupon): void
    {
        $this->couponRepository->delete($coupon);
    }

    public function updateCoupon(Coupon $coupon, array $data): void
    {
        $this->couponRepository->update($coupon, $data);
    }

    public function allCoupons()
    {
        return $this->couponRepository->all();
    }

    public function findCoupon(int $id): Coupon
    {
        return $this->couponRepository->find($id);
    }

    public function allProducts()
    {
        return $this->couponRepository->allProducts();
    }

    public function addProduct(Coupon $coupon, array $productIds): bool
    {
        try {
            
            $existingProductIds = $this->couponRepository->couponProducts($coupon)->pluck('id')->toArray();

           
            $newProductIds = array_diff($productIds, $existingProductIds);

           
            if (!empty($newProductIds)) {
                $this->couponRepository->addProduct($coupon, $newProductIds);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Error adding products to coupon: ' . $e->getMessage());
            throw $e; 
        }
    }

    public function allProductsInCoupon()
    {
         return $this->couponRepository->allProductsInCoupon();
      
       
    }
}

<?php

namespace App\Repositories\Admin\Purchase;

use App\Models\Purchase;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function createPurchase(array $data): Purchase
    {
        // Remove 'products' from data before creating purchase
        $purchaseData = collect($data)->except('products')->toArray();

        // Create purchase without products column
        $purchase = Purchase::create($purchaseData);

        return $purchase;
    }
}

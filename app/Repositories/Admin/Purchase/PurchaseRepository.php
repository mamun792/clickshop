<?php

namespace App\Repositories\Admin\Purchase;

use App\Models\Purchase;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function createPurchase(array $data): Purchase
    {

        $purchaseData = collect($data)->except('products')->toArray();


        $purchase = Purchase::create($purchaseData);

        return $purchase;
    }
}

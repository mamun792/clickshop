<?php


namespace App\Services\Admin\Purchase;

interface PurchaseServiceInterface
{
    public function createPurchase(array $data): array;
}

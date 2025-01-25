<?php



namespace App\DTOs;

class PurchaseDTO
{
    public int $productId;
    public array $attributes;
    public string $rawVariant;
    public string $formattedVariant;

    public function __construct(int $productId, array $attributes, string $rawVariant, string $formattedVariant)
    {
        $this->productId = $productId;
        $this->attributes = $attributes;
        $this->rawVariant = $rawVariant;
        $this->formattedVariant = $formattedVariant;
    }

}

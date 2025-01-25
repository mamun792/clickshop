<?php

namespace App\Repositories\Admin\Product;

use App\Models\Product;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function index();
    public function getProductCreationData();
    ////////////////////
    public function createProduct(array $validatedData);
   // public function createProductAttributes($productId, array $attributes, array $singleOptions,$combinationsIds);
    public function createProductCombinations($productId, array $combinations);
    public function handleProductAttributes($productId, array $data);


    public function  handleProductAttributesUpdate($productId, array $data);

    ////////////////////


    public function filterProducts(array $filters);
    public function getCategories();
    public function getSubCategories();

    public function bulkDelete(array $productIds);

    public function bulkPublish(array $productIds);

    public function bulkUnpublish(array $productIds);

    public function updateFreeShipping(int $productId, bool $isFreeShipping);
}

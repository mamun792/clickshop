<?php

namespace App\Services\Admin\Product;

use App\Models\AttributeOption;
use App\Repositories\Admin\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        return $this->productRepository->index();
    }

    public function getProductCreationData()
    {
        return $this->productRepository->getProductCreationData();
    }

    public function storeProduct(Request $request)
    {
        $validatedData = $request->all();

        // Call the repository method to create the product
        $product = $this->productRepository->createProduct($validatedData);

        // Ensure attributes are in array format

        if (isset($validatedData['attributes']) && !empty($validatedData['attributes'])) {
        $attributes = is_array($validatedData['attributes'])
            ? $validatedData['attributes']
            : json_decode($validatedData['attributes'], true);

        $attributePrices = $validatedData['attribute_prices'] ?? [];
        $attributeQuantities = $validatedData['attribute_quantities'] ?? [];



        // Call the repository method to create product attributes
       // $this->productRepository->createProductAttributes($product, $attributes, $attributePrices, $attributeQuantities);
       $this->productRepository->handleProductAttributes($product->id, $request->all());
    //    $this->productRepository->createProductCombinations($product->id, $attributes);

        }


        return $product;
    }


    public function  handleProductAttributesUpdate($productId, array $data)
    {
      

        return $this->productRepository->handleProductAttributesUpdate($productId, $data);
    }



    public function filterProducts(array $filters)
    {
        return $this->productRepository->filterProducts($filters);
    }

    public function getCategories()
    {
        return $this->productRepository->getCategories();
    }

    public function getSubCategories()
    {
        return $this->productRepository->getSubCategories();
    }

    public function bulkDelete(array $productIds)
    {
        return $this->productRepository->bulkDelete($productIds);
    }

    public function bulkPublish(array $productIds)
    {
        return $this->productRepository->bulkPublish($productIds);
    }

    public function bulkUnpublish(array $productIds)
    {
        return $this->productRepository->bulkUnpublish($productIds);
    }

    public function updateFreeShipping(int $productId, bool $isFreeShipping)
    {
        return $this->productRepository->updateFreeShipping($productId, $isFreeShipping);
    }




}

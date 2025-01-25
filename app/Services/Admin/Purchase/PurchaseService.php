<?php

namespace App\Services\Admin\Purchase;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeCombination;
use App\Repositories\Admin\Purchase\PurchaseRepository;
use App\Repositories\Admin\Purchase\PurchaseRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class PurchaseService implements PurchaseServiceInterface
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }



    public function createPurchase(array $data): array
    {

        return DB::transaction(function () use ($data) {
            $purchase = $this->purchaseRepository->createPurchase($data);

            $products = $this->formatPurchaseProducts($data['products']);

            // Log::info('formatted products', ['products' => json_encode($products)]);
            // die();

            // Log the number of products being processed


            // foreach ($products as $product) {
            $this->processPurchaseProduct($purchase, $products);
            // }

            return [
                'message' => 'Purchase created successfully.',
                'purchase_id' => $purchase->id,
            ];
        });
    }

    private function processPurchaseProduct($purchase, array $productData)
    {

        // Loop through each product data and access the product_id



        foreach ($productData['single']  as $productId => $singleProduct) {
            // Retrieve the product using the product_id from $productData
            $productId = $singleProduct['product_id'];
            $product = Product::findOrFail($productId);
             $product->purchase_id=$purchase->id;
           //save the purchase id to the product
            $product->save();


            $this->handleSingleAttributeProduct($product, $singleProduct);
        }

        foreach ($productData['multiple'] as $productId => $multiProduct) {
            // Retrieve the product using the product_id from $productData
            $productId = $multiProduct['product_id'];
            $product = Product::findOrFail($productId);
            $product->purchase_id=$purchase->id;
            //save the purchase id to the product
            $product->save();



            // Log the product ID
            $this->handleMultiAttributeProduct($product, $multiProduct);
        }
    }


    private function handleSingleAttributeProduct(Product $product, array $productData)
    {


        DB::transaction(function () use ($product, $productData) {
            // Log the entire product data for debugging
            // Log::info($productData);

            $totalQuantity = 0;
            // Access and process the attributes
            $attributes = $productData['attributes'];
            foreach ($attributes as $attribute) {
                // Log each attribute for debugging
                // Log::info('Processing Attribute:', $attribute);

                // Example: Save attribute data to a database
                DB::table('product_attributes')->insert([
                    'product_id' => $product['id'], // Assuming product is an array or object with `id`
                    'attribute_id' => $attribute['attribute_id'],
                    'attribute_option_id' => $attribute['option_id'],
                    'price' => $attribute['price'],
                    'quantity' => $attribute['quantity'],
                    'status' => 'enable',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Increment the total quantity
                $totalQuantity += $attribute['quantity'];

            }

            // Increment the product quantity
            $product->increment('quantity', $totalQuantity);

        });
    }


    private function handleMultiAttributeProduct(Product $product, array $productData)
    {
        DB::transaction(function () use ($product, $productData) {
            // Create combination record
            $combination = ProductAttributeCombination::firstOrCreate([
                'product_id' => $product->id,
                'combination_string' => $productData['raw_variant']
            ]);

            $totalQuantity = 0;

            // Create product attributes for each attribute
            foreach ($productData['attributes'] as $attribute) {
                $productAttribute = ProductAttribute::updateOrCreate([
                    'product_id' => $product->id,
                    'combination_id' => $combination->id,
                    'attribute_id' => $attribute['attribute_id'],
                    'attribute_option_id' => $attribute['option_id']
                ], [
                    'price' => $attribute['price'],
                    'quantity' => $attribute['quantity'],
                    'status' => 'enable'
                ]);

                // Increment the total quantity
                $totalQuantity += $attribute['quantity'];
            }

            // Increment product total quantity
            $product->increment('quantity', $totalQuantity);
        });
    }







    private function formatPurchaseProducts(string $productsJson): array
    {
        $products = json_decode($productsJson, true);

        // Map the formatted products
        $formattedProducts = array_map([$this, 'formatProductData'], $products);

        // Group products into "single" and "multiple"
        return [
            'single' => array_filter($formattedProducts, fn($product) => count($product['attributes']) === 1),
            'multiple' => array_filter($formattedProducts, fn($product) => count($product['attributes']) > 1),
        ];
    }

    private function formatProductData(array $rawProduct): array
    {
        $variantParts = explode(' - ', $rawProduct['variant']);
        $attributeIds = explode(',', $rawProduct['attributeIds']);
        $optionIds = explode(',', $rawProduct['optionIds']);
        $attributes = [];

        foreach ($variantParts as $index => $part) {
            [$name, $value] = explode(': ', $part);
            $attributes[] = [
                'name' => $name,
                'value' => $value,
                'attribute_id' => $attributeIds[$index] ?? null,
                'option_id' => $optionIds[$index] ?? null,
                'price' => $rawProduct['price'],
                'quantity' => (int) $rawProduct['quantity'],
            ];
        }

        return [
            'product_id' => (int) $rawProduct['productId'],
            'attributes' => $attributes,
            'raw_variant' => $rawProduct['variant'],
            'formatted_variant' => json_encode($attributes),
        ];
    }
}

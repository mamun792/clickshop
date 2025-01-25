<?php

namespace App\Repositories\Admin\Product;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeCombination;
use App\Models\SubCategory;
use App\Traits\FileUploadTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;




class ProductRepository implements ProductRepositoryInterface
{
    use FileUploadTrait;
    private $processedAttributeOptions = [];
    private $processedCombinations = [];
    public function index()
    {
        // Retrieve products with their related category and subcategory
        $products = Product::latest()
            ->with('category', 'subcategory')
            ->get();

        // Retrieve categories and subcategories
        $categories = Category::orderBy('name', 'asc')->get();
        $subcategories = SubCategory::orderBy('name', 'asc')->get();

        // Return the data in a structured format
        return [
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ];
    }

    public function getProductCreationData()
    {
        $attributeOptions = AttributeOption::with('product')->get();
        $attributes = Attribute::with('attributeOptions')->get();

        $categories = Category::orderBy('name')->where('status', 'Active')->get();
        $brands = Brand::orderBy('company')->get();

        return [
            'attributes' => $attributes,
            'attributeOptions' => $attributeOptions,
            'categories' => $categories,
            'brands' => $brands,
        ];
    }




    // In ProductRepository

    public function createProduct(array $data)
    {
        if (isset($data['featured_image'])) {
            // Pass the whole request and the input name to the uploadFile method
            $data['featured_image'] = $this->uploadFile($data['featured_image'], 'featured_image', null, 'products');
        }

        // Handle gallery images upload
        if (isset($data['gallery_images']) && is_array($data['gallery_images'])) {
            $data['gallery_images'] = $this->uploadMultipleFiles($data['gallery_images'], 'products')['savedImages'];
        } else {
            $data['gallery_images'] = []; // Default to an empty array if no images provided
        }



        $product = Product::create([
            'product_name' => $data['product_name'],
            'product_code' => $data['product_code'] ?? $data['purchase_product_code'],
            'short_description' => $data['short_description'],
            'description' => $data['description'],
            'product_tag' => json_encode($data['product_tag']),
            'specification' => json_encode($data['specification']),
            'stock_option' => $data['stock_option'] ?? 'Manual',
            'quantity' => $data['quantity'],
            'price' => $data['price'],
            'previous_price' => $data['previous_price'],
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'] ?? null,
            'brand_id' => $data['brand_id'] ?? null,
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'featured_image' => asset($data['featured_image']) ?? null,
            'gallery_images' => isset($data['gallery_images']) ? json_encode($data['gallery_images']) : json_encode([]), // Fallback to an empty array
        ]);

        return $product;
    }





    // new code
    public function handleProductAttributes($productId, array $data)
    {
        // Log::info('Handling product attributes', ['product_id' => $productId]);
        $this->processedAttributeOptions = [];
        $normalizedData = $this->normalizeInputData($data);

        // Handle single options
        if (!empty($normalizedData['singleOptions'])) {
            //  Log::info('Processing single attributes', ['singles' => $normalizedData['singleOptions']]);
            $this->createSingleAttributes($productId, $normalizedData['singleOptions']);
        }

        // Handle combinations
        if (!empty($normalizedData['combinations'])) {
            //  Log::info('Processing product combinations', ['combinations' => $normalizedData['combinations']]);
            $this->createProductCombinations($productId, $normalizedData['combinations']);
        }
    }


    // update  prodeuct
    public function handleProductAttributesUpdate($productId, array $data)
    {
        // Log::info('Handling product attributes', ['product_id' => $productId]);
        $this->processedAttributeOptions = [];
        $normalizedData = $this->normalizeInputData($data);

        // Handle single options
        if (!empty($normalizedData['singleOptions'])) {
            //  Log::info('Processing single attributes', ['singles' => $normalizedData['singleOptions']]);
            $this->createSingleAttributes($productId, $normalizedData['singleOptions']);
        }

        // Handle combinations
        if (!empty($normalizedData['combinations'])) {
            //  Log::info('Processing product combinations', ['combinations' => $normalizedData['combinations']]);
            $this->createProductCombinations($productId, $normalizedData['combinations']);
        }
    }

    public function createProductCombinations($productId, array $combinations)
    {
        $exiting=  ProductAttributeCombination::where('product_id', $productId);

        if($exiting->exists()){
            $exiting->delete();
        }

        $combinationsData = [];

        foreach ($combinations as $combination) {
            $combinationsData[] = [
                'product_id' => $productId,
                'combination_string' => $combination['attributes'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Batch insert combinations
        ProductAttributeCombination::insert($combinationsData);

        // Fetch the inserted IDs
        $combinedIds = ProductAttributeCombination::where('product_id', $productId)
            ->latest('id')
            ->take(count($combinationsData))
            ->pluck('id')
            ->toArray();



        // Create attributes for each combination
        foreach ($combinations as $index => $combination) {
            $attributesArray = json_decode($combination['attributes'], true);
            $this->createCombinationAttributes(
                $productId,
                $attributesArray,
                $combination,
                $combinedIds[$index]
            );
        }
    }

    private function createCombinationAttributes($productId, array $attributes, array $combinationData, $combinationId)
    {
        Log::info('Creating combination attributes', [
            'product_id' => $productId,
            'attributes' => $attributes,
            'combination_data' => $combinationData,
            'combination_id' => $combinationId,
        ]);

        // Decode the attributes JSON string if it exists in combination_data
        $combinationAttributes = isset($combinationData['attributes'])
            ? json_decode($combinationData['attributes'], true)
            : [];

        // Get the correct quantity and price
        $quantity = $combinationData['quantity'] ?? 0;
        $price = $combinationData['price'] ?? 0;
        $sold_quantity = $combinationData['sold_quantity'] ?? 0;

        // If we're editing (combinationId exists), first delete existing attributes
        if ($combinationId) {
            ProductAttribute::where('combination_id', $combinationId)->delete();
        }

        foreach ($attributes as $attribute) {
            $attributeId = (int)$attribute['attributeId'];
            $optionId = (int)$attribute['optionId'];
            $key = $this->getAttributeOptionKey($attributeId, $optionId);

            // Create product attribute for this combination option
            ProductAttribute::create([
                'product_id' => $productId,
                'attribute_id' => $attributeId,
                'attribute_option_id' => $optionId,
                'quantity' => $quantity,  // Use the correct quantity from combination_data
                'price' => $price,        // Use the correct price from combination_data
                'sold_quantity' => $sold_quantity,        // Use the correct price from combination_data
                'combination_id' => $combinationId
            ]);

            // Mark this attribute-option pair as processed
            $this->processedAttributeOptions[$key] = true;
        }

        // Update product quantity
        $this->updateProductQuantity($productId);
    }



    private function normalizeInputData(array $data): array
    {
        $normalized = [
            'singleOptions' => [],
            'combinations' => []
        ];

        // Normalize singleOptions
        if (isset($data['singleOptions'])) {
            if (is_array($data['singleOptions'])) {
                if ($this->isSequentialArray($data['singleOptions'])) {
                    $normalized['singleOptions'] = $data['singleOptions'];
                } else {
                    foreach ($data['singleOptions'] as $key => $option) {
                        $normalized['singleOptions'][] = $option;
                    }
                }
            }
        }

        // Normalize combinations
        if (isset($data['combinations'])) {
            if (is_array($data['combinations'])) {
                if ($this->isSequentialArray($data['combinations'])) {
                    $normalized['combinations'] = $data['combinations'];
                } else {
                    foreach ($data['combinations'] as $key => $combination) {
                        $normalized['combinations'][] = $combination;
                    }
                }
            }
        }

        return $normalized;
    }

    private function isSequentialArray($array): bool
    {
        if (!is_array($array)) return false;
        return array_keys($array) === range(0, count($array) - 1);
    }

    private function createSingleAttributes($productId, array $singles)
    {
        // checl if the product has any attributes has existing then delecte them create new one

       $exiting=    ProductAttribute::where('product_id', $productId);

       if($exiting->exists()){
           $exiting->delete();
       }


        foreach ($singles as $single) {
            $key = $this->getAttributeOptionKey((int)$single['attributeId'], (int)$single['optionId']);

            // Skip if this attribute-option pair has already been processed
            if (isset($this->processedAttributeOptions[$key])) {
                continue;
            }

            ProductAttribute::create([
                'product_id' => $productId,
                'attribute_id' => (int)$single['attributeId'],
                'attribute_option_id' => (int)$single['optionId'],
                'quantity' => $single['quantity'] ?? 0,
                'price' => $single['price'] ?? 0,
                'sold_quantity' => $single['sold_quantity'] ?? 0,
                'combination_id' => null
            ]);

            $this->processedAttributeOptions[$key] = true;
        }

        // Update product quantity
        $this->updateProductQuantity($productId);
    }



    // mamun

    private function updateProductQuantity($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            logger()->error("Product not found with ID: {$productId}");
            return;
        }

        $productAttributes = ProductAttribute::where('product_id', $productId)->get();

        if ($productAttributes->isNotEmpty()) {
            $totalQuantity = $productAttributes->sum('quantity');
            logger()->info("Updating Product Quantity for ID: {$productId}, Total: {$totalQuantity}");
            $product->quantity = $totalQuantity;
            $product->save();
        } else {
            logger()->warning("No Product Attributes found for Product ID: {$productId}");
        }
    }






    private function getAttributeOptionKey(int $attributeId, int $optionId): string
    {
        return $attributeId . '_' . $optionId;
    }


    private function getOptionNameById($optionId)
    {
        $option = AttributeOption::find($optionId);

        if (!$option) {
            // Log::warning("Attribute option not found for ID: {$optionId}");
            return 'Unknown';
        }

        return $option->name;
    }


    public function filterProducts(array $filters)
    {
        $query = Product::query();

        // Apply filters based on the passed filters array
        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['subcategory_id'])) {
            $query->where('subcategory_id', $filters['subcategory_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['product_name'])) {
            $query->where('product_name', 'like', '%' . $filters['product_name'] . '%');
        }

        if (isset($filters['product_code'])) {
            $query->where('product_code', $filters['product_code']);
        }

        // Eager load category and subcategory relationships
        $products = $query->with(['category', 'subcategory'])->get();

        return $products;
    }

    public function getCategories()
    {
        return Category::orderBy('name', 'asc')->get();
    }

    public function getSubCategories()
    {
        return SubCategory::orderBy('name', 'asc')->get();
    }

    public function bulkDelete(array $productIds)
    {
        Product::whereIn('id', $productIds)->delete();
    }

    public function bulkPublish(array $productIds)
    {
        Product::whereIn('id', $productIds)->update(['status' => 'Published']);
    }

    public function bulkUnpublish(array $productIds)
    {
        Product::whereIn('id', $productIds)->update(['status' => 'Unpublished']);
    }

    public function updateFreeShipping(int $productId, bool $isFreeShipping)
    {
        $product = Product::findOrFail($productId);
        $product->is_free_shipping = $isFreeShipping;
        $product->save();
    }
}

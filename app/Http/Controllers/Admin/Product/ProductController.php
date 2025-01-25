<?php

namespace App\Http\Controllers\Admin\Product;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductRequest;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeCombination;
use App\Models\PurchaseGroup;
use App\Models\SubCategory;
use App\Repositories\Admin\Product\ProductRepositoryInterface;
use App\Services\Admin\Product\ProductService;
use Illuminate\Http\Request;


use App\Traits\FileUploadTrait;

use Illuminate\Support\Facades\Log;

use function Pest\Laravel\json;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      use FileUploadTrait;

    protected $productService;
    protected $productRepository;

    public function __construct(ProductService $productService, ProductRepositoryInterface $productRepository)
    {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $data = $this->productService->index();

        return view('admin.products.index', [
            'product' => $data['products'],
            'category' => $data['categories'],
            'subcategory' => $data['subcategories'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data = $this->productService->getProductCreationData();

        return view('admin.products.create', [
            'attributes' => $data['attributes'],
            'attributeOptions' => $data['attributeOptions'],
            'categories' => $data['categories'],
            'brands' => $data['brands'],
        ]);
    }

    /**
     * Store a newly created resource in storage.ProductRequest
     */

    public function store(ProductRequest $request)
    {
        //   return $request->all();
        $this->productService->storeProduct($request);

        return redirect()->route('products.index')->with('success', 'New product created successfully');
    }







    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $product = Product::where('id', $id)->with('product_attributes')->first();



        // Decode the product_tag JSON array properly
        $productTags = json_decode($product->product_tag, true); // Decode the first layer
        $tagValues = [];

        if ($productTags !== null) { // Check if $productTags is not null
            if (is_array($productTags) && !empty($productTags)) {
                foreach ($productTags as $tagJson) {
                    $tags = json_decode($tagJson, true); // Decode the inner JSON
                    if (is_array($tags)) { // Ensure $tags is an array
                        foreach ($tags as $tag) {
                            if (isset($tag['value'])) { // Check if 'value' exists
                                $tagValues[] = $tag['value']; // Extract only the 'value' field
                            }
                        }
                    }
                }
            }
        }

        // $tagValues now contains the extracted values or remains empty if no valid data exists




        // Decode the specification
        $specifications = json_decode($product->specification, true);



        $attributes = Attribute::with('attribute_option')->get();
        $productAttributes = $product->product_attributes->pluck('attribute_option_id')->toArray();


        $SingleAttribute = ProductAttribute::where('product_id', $product->id)
            ->where('combination_id', null)
            ->get();



        $productCombinations = ProductAttributeCombination::where('product_id', $product->id)->get();

        foreach ($productCombinations as $combination) {
            // Decode the combination string to get option IDs
            $combinationData = json_decode($combination->combination_string, true);
            Log::info('Combine data', ['combinedata' => $combinationData]);

            if (is_array($combinationData)) {
                // Fetch all attributes related to the combination
                $relatedAttributes = ProductAttribute::where('product_id', $product->id)
                    ->where('combination_id', $combination->id)
                    ->get();
                Log::info('relatedAttributes', ['relatedAttributes' => $relatedAttributes->toArray()]);

                // Check if the combination matches perfectly
                $matchingAttribute = $relatedAttributes->filter(function ($attribute) use ($combinationData) {
                    // Ensure all attributes in $combinationData match this attribute
                    foreach ($combinationData as $data) {
                        if (
                            $data['attributeId'] == $attribute->attribute_id &&
                            $data['optionId'] == $attribute->attribute_option_id
                        ) {
                            continue;
                        }
                        return false; // If any mismatch, filter it out
                    }
                    return true; // Perfect match
                })->first();

                if ($matchingAttribute) {
                    // Update combination with the correct price and quantity
                    $combination->price = number_format((float)$matchingAttribute->price, 2);
                    $combination->quantity = (int)$matchingAttribute->quantity;
                } else {
                    // Set defaults if no matching attribute is found
                    $combination->price = "0.00";
                    $combination->quantity = 0;
                }

                // Add all related attributes to the combination
                $combination->attributes = $relatedAttributes;
            } else {
                Log::error('Failed to decode combination data', ['combination_string' => $combination->combination_string]);
                $combination->price = "0.00";
                $combination->quantity = 0;
            }
        }




        $categories = Category::orderBy('name')->where('status', 'Active')->get();
        $sub_categories = SubCategory::where('category_id', $product->category_id)->orderBy('name')->where('status', 'Active')->get();
        $brands = Brand::orderBy('company')->get();

        return view('admin.products.edit', compact('attributes', 'categories', 'brands', 'product', 'tagValues', 'specifications', 'sub_categories', 'productAttributes', 'productCombinations', 'SingleAttribute'));
    }










    /**
     * Update the specified resource in storage.ProductRequest
     */
    public function update(Request $request, Product $product)
    {

        $validatedData = $request->all();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {

            // Optionally delete the old image before uploading the new one

            $exitingImage = $product->featured_image;


            $validatedData['featured_image'] = $this->updateFile($request->file('featured_image'),  $exitingImage, 'products');
        }

// Get the existing images from the request payload (submitted via formData)
$existingImages = $request->input('gallery_images', []); // This should be an array or a string

// If existingImages is a string (JSON format), decode it into an array
if (is_string($existingImages)) {
    $existingImages = json_decode($existingImages, true); // Decode the string to an array
}

// Ensure $existingImages is an array (defaults to empty array if not provided or valid)
$existingImages = is_array($existingImages) ? $existingImages : [];

// Process new gallery images (if any)
$newGalleryImages = [];

// If new gallery images are uploaded
if ($request->hasFile('gallery_images')) {
    // Update the gallery images and get the new images
    $savedGalleryImages = $this->updateProductGallery($request, $product);
    if (!empty($savedGalleryImages)) {
        // Ensure $savedGalleryImages is an array before using it
        $newGalleryImages = $savedGalleryImages;
    }
}

// If $newGalleryImages is a string (from json_encode), decode it back to an array
if (isset($newGalleryImages) && is_string($newGalleryImages)) {
    $newGalleryImages = json_decode($newGalleryImages, true);
}

// Ensure that $newGalleryImages is an array (defaults to an empty array if not)
$newGalleryImages = is_array($newGalleryImages) ? $newGalleryImages : [];

// Combine existing images from the request with the new gallery images
$finalGalleryImages = array_merge($existingImages, $newGalleryImages);




        // Ensure JSON fields are encoded properly
        $jsonFields = ['product_tag', 'specification', 'attributes'];
        foreach ($jsonFields as $jsonField) {
            if (isset($validatedData[$jsonField]) && is_array($validatedData[$jsonField])) {
                $validatedData[$jsonField] = json_encode($validatedData[$jsonField]);
            }
        }


        // Update product data
        $product->update([
            'product_name' => $validatedData['product_name'],
            'product_code' => $validatedData['product_code'],

            'short_description' => $validatedData['short_description'],
            'description' => $validatedData['description'],
            'product_tag' => $validatedData['product_tag'],
            'specification' => $validatedData['specification'],
            'stock_option' => $validatedData['stock_option'],
            'quantity' => $validatedData['quantity'],
            'price' => $validatedData['price'],
            'previous_price' => $validatedData['previous_price'],
            'category_id' => $validatedData['category_id'],
            'subcategory_id' => $validatedData['subcategory_id'] ?? null,
            'brand_id' => $validatedData['brand_id'] ?? null,
            'meta_title' => $validatedData['meta_title'],
            'meta_description' => $validatedData['meta_description'],
            'featured_image' => $validatedData['featured_image'] ?? $product->featured_image,
            'gallery_images' => json_encode($finalGalleryImages ?? $product->gallery_images),

        ]);

        //Handle to update productAttribute
        $exiting =  ProductAttribute::where('product_id', $product->id);
        $exitingCom =  ProductAttributeCombination::where('product_id', $product->id);

        if ($exiting->exists() || $exitingCom->exists()) {
            $exiting->delete();
            $exitingCom->delete();
        }

        $this->productRepository->handleProductAttributes($product->id, $request->all());

        return redirect()->back()->with('success', 'Product updated successfully');
    }




    public function destroy(string $id)
    {
        // Find the product by its ID
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }



        $this->deleteFeaturedImage($product->featured_image);

        // Delete gallery images if they exist
        $this->deleteGalleryImages($product->gallery_images);




        // Delete the product from the database
         $product->delete();



        // Redirect back with a success message
        return redirect()->back()->with('success', 'Product item deleted');
    }





    public function getSubcategories($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->where('status', 'Active')->get();
        return response()->json($subcategories);
    }

    public function toggleStatus(Product $product)
    {
        // Toggle the status
        $product->status = $product->status === 'Published' ? 'Unpublished' : 'Published';
        $product->save();

        // Return a JSON response
        return response()->json([
            'status' => $product->status,
            'message' => 'Product status updated successfully!',
        ]);
    }

    public function toggleFeature(Product $product)
    {
        // Toggle the status
        $product->feature = $product->feature === 'New Arrival' ? 'None' : 'New Arrival';
        $product->save();

        // Return a JSON response
        return response()->json([
            'feature' => $product->feature,
            'message' => 'Product status updated successfully!',
        ]);
    }


    public function getPurchaseData($product_code)
    {
        // Fetch data from the purchase_groups table
        $purchaseGroup = PurchaseGroup::where('product_code', $product_code)->first();

        if ($purchaseGroup) {
            return response()->json([
                'status' => 'success',
                'data' => $purchaseGroup
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Product code not found.'
        ], 404);
    }


    public function filter(Request $request)
    {


        $filters = $request->only([
            'category_id',
            'subcategory_id',
            'status',
            'product_name',
            'product_code'
        ]);

        // Get the filtered products from the service
        $product = $this->productService->filterProducts($filters);

        // Get categories and subcategories
        $category = $this->productService->getCategories();
        $subcategory = $this->productService->getSubCategories();

        // Return view with filtered data
        return view('admin.products.index', compact('product', 'category', 'subcategory'));
    }


    public function bulkDelete(Request $request)
    {


        $productIds = $request->input('ids');

        if (empty($productIds)) {
            return response()->json(['message' => 'No products selected'], 400);
        }

        // Call service method to delete products
        $this->productService->bulkDelete($productIds);

        return response()->json(['message' => 'Products deleted successfully']);
    }


    public function bulkPublish(Request $request)
    {
        // Validate that `ids` is provided and is an array
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        // Update the status of selected products
        $this->productService->bulkPublish($request->ids);

        // Return success response using ApiResponse
        return ApiResponse::success([], 'Selected products have been published successfully.');
    }


    public function bulkUnpublish(Request $request)
    {
        // Validate that `ids` is provided and is an array
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        // Update the status of selected products
        $this->productService->bulkUnpublish($request->ids);

        // Return success response using ApiResponse
        return ApiResponse::success([], 'Selected products have been Unpublished successfully.');
    }


    public function updateFreeShipping(Request $request, $productId)
    {


        $this->productService->updateFreeShipping($productId, $request->is_free_shipping);

        // Return response as JSON
        return response()->json(['success' => true]);
    }
}

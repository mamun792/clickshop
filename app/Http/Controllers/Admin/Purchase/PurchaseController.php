<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseGroup;
use App\Models\Supplier;
use App\Services\Admin\Product\ProductService;
use App\Services\Admin\Purchase\PurchaseService;
use App\Services\Admin\Purchase\PurchaseServiceInterface;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{

    use FileUploadTrait;
    protected $productService;
    protected $purchaseService;

    public function __construct(ProductService $productService, PurchaseService $purchaseService)
    {
        $this->productService = $productService;
        $this->purchaseService = $purchaseService;
    }


    public function index()
    {
       $purchase = Purchase::orderBy('purchase_name')->with('supplier')->get();
        // return $purchase;
        return view('admin.purchase.index', compact('purchase'));
    }


    public function create()
    {
        try {


            $data = $this->productService->getProductCreationData();

            // Convert the object to an array
            $data = json_decode(json_encode($data), true);

            // Now you can access it more easily like a simple array
            $attributes = $data['attributes'];



            // Get products eligible for purchase
            $products = Product::where('stock_option', 'From Purchase')
                ->orderBy('id', 'desc')
                ->select('id', 'product_name', 'product_code', 'price')
                ->get();

            // Get suppliers
            $suppliers = Supplier::orderBy('supplier_name')->get();

            return view('admin.purchase.create', compact('attributes', 'products', 'suppliers'));
        } catch (\Exception $e) {
            // \Log::error('Error in purchase create: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error loading purchase form. Please try again.');
        }
    }

    public function store(Request $request)
    {

       Log::info($request->all());
       return $request->all();

        $validatedData=$request->all();

        $formattedProducts = $this->purchaseService->createPurchase($validatedData);
        // Log::info($formattedProducts);



        die();
        return $request->all();


        // Upload image and get path if image is provided
        if ($request->hasFile('document')) {
            $data['document'] = $this->uploadFile($request, 'document');
        }

        // Store the validated data
        $purchase = Purchase::create($data);

        // Return JSON response with purchase_id
        return response()->json([
            'message' => 'Purchase created successfully.',
            'purchase_id' => $purchase->id,  // Sending the purchase_id in the response
        ]);
    }

    public function edit($id)
    {
        $purchase = Purchase::where('id', $id)->with('purchase_group')->first();
        $suppliers = Supplier::orderBy('supplier_name')->get();

        return view('admin.purchase.edit', compact('purchase', 'suppliers'));
    }


    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        $data = $request->validate([
            'purchase_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'invoice_number' => 'required|string|max:255|unique:purchases,invoice_number,' . $purchase->id, // Unique excluding current record by id
            'supplier_id' => 'required|integer|exists:suppliers,id', // Check if supplier_id exists in suppliers table
            'document' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:2048', // Optional file with specific types
            'comment' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('document')) {
            // Delete the old document if it exists
            if ($purchase->document && file_exists(public_path($purchase->document))) {
                unlink(public_path($purchase->document));
            }

            // Upload and store the new document path
            $data['document'] = $this->uploadFile($request, 'document');
        }

        // Update the purchase record with validated data
        $purchase->update($data);

        // Return JSON response with a success message
        return response()->json([
            'message' => 'Purchase updated successfully.',
            'purchase_id' => $purchase->id,
        ]);
    }


    public function destroy($id)
    {



        Purchase::find($id)->delete();

        return redirect()->back()->with('success', 'Purchase item deleted');
    }




    public function productStore(Request $request)
    {
        Log::info($request->all());
        return $request->all();
        // $purchase_id = $request->purchase_id;
        // foreach ($request->name as $index => $name) {
        //     PurchaseGroup::create([
        //         'purchase_id' => $purchase_id,
        //         'name' => $name,
        //         'product_code' => $request->product_code[$index],
        //         'quantity' => $request->quantity[$index],
        //         'price' => $request->price[$index],
        //         'total' => $request->total[$index],
        //     ]);
        // }

        return response()->json(['message' => 'Products added successfully']);
    }



    public function productUpdate(Request $request)
    {
        PurchaseGroup::query()->delete();

        $purchase_id = $request->purchase_id;

        foreach ($request->name as $index => $name) {
            $productData = [
                'name' => $name,
                'product_code' => $request->product_code[$index],
                'quantity' => $request->quantity[$index],
                'price' => $request->price[$index],
                'total' => $request->total[$index],
            ];

            // Check if there's an ID in the request to determine if it's an update or create action
            if (isset($request->id[$index])) {
                // Update existing product if ID is provided
                $product = PurchaseGroup::where('id', $request->id[$index])
                    ->where('purchase_id', $purchase_id)
                    ->first();

                if ($product) {
                    $product->update($productData);
                }
            } else {
                // Create a new product if no ID is provided
                PurchaseGroup::create(array_merge($productData, ['purchase_id' => $purchase_id]));
            }
        }

        return response()->json(['message' => 'Products updated successfully']);
    }

    public function productDelete(Request $request)
    {
        try {
            // Find the product by ID
            $data = PurchaseGroup::findOrFail($request->product_id);

            // Delete the product
            $data->delete();

            // Return success message
            return response()->json([
                'message' => 'Data deleted successfully.'
            ]);
        } catch (\Exception $e) {
            // Handle any errors, such as database errors or product not found
            return response()->json([
                'message' => 'There was an error deleting the product.',
            ], 500); // 500 is the status code for server errors
        }
    }


    public function formatProductData(array $rawProduct): array
    {
        // Split variant string into individual attributes
        $variantParts = explode(' - ', $rawProduct['variant']);

        // Create structured attributes array
        $attributes = [];
        $attributeIds = explode(',', $rawProduct['attributeIds']);
        $optionIds = explode(',', $rawProduct['optionIds']);
        $quantity = explode(',', $rawProduct['quantity']);
        $price = explode(',', $rawProduct['price']);

        foreach ($variantParts as $index => $part) {
            [$name, $value] = explode(': ', $part);
            $attributes[] = [
                'name' => $name,
                'value' => $value,
                'attribute_id' => $attributeIds[$index] ?? null,
                'option_id' => $optionIds[$index] ?? null,
                'price' => $rawProduct['price']  ,
                'quantity' => $rawProduct['quantity']
            ];
        }

        // Return structured format
        return [
            'product_id' => (int) $rawProduct['productId'],
            'attributes' => $attributes,
            'raw_variant' => $rawProduct['variant'],  // Keep original for reference
            'formatted_variant' => json_encode($attributes)  // Store as JSON
        ];
    }

    public function formatPurchaseProducts(string $productsJson): array
    {
        $products = json_decode($productsJson, true);
        return array_map([$this, 'formatProductData'], $products);
    }
}

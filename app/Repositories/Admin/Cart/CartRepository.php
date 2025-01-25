<?php

namespace App\Repositories\Admin\Cart;

use App\Models\Cart;
use App\Models\CartAttribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use Attribute;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartRepositoryInterface
{


    public function getCartItems($userId)
    {
        // Ensure user ID is provided
        if (!$userId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        // Fetch the cart items for the given user ID
        $cartItems = Cart::where('user_identifier', $userId)
            ->with([
                'product',
                'cartAttributes.attributes',
                'cartAttributes.attributeOption',
                'cartAttributes.productAttribute',
            ])
            ->get();


        $cartData = $cartItems->map(function ($cartItem) {

            $attributesPrice = $cartItem->cartAttributes->sum(function ($cartAttribute) {
                return $cartAttribute->productAttribute->price ?? 0; // Sum of attribute prices
            });


            $basePrice = (float) $cartItem->product->price;
            $discount = (float) $cartItem->discount_value;
            $individualPrice = $basePrice + $attributesPrice - $discount;


            $finalPrice = $individualPrice * $cartItem->quantity;

            return [
                'id' => $cartItem->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'campaign_id' => $cartItem->campaign_id,
                'discount_value' => $cartItem->discount_value,
                'product' => [
                    'id' => $cartItem->product->id,
                    'product_name' => $cartItem->product->product_name,
                    'price' => $cartItem->product->price,
                    'featured_image' => $cartItem->product->featured_image,
                ],
                'attributes' => $cartItem->cartAttributes->map(function ($cartAttribute) {
                    return [
                        'price' => $cartAttribute->productAttribute->price ?? null,
                        'attribute_name' => $cartAttribute->attributes->name ?? null,
                        'attribute_option_id' => $cartAttribute->attributeOption->id ?? null,
                        'attribute_option' => $cartAttribute->attributeOption->name ?? null,
                        'product_attr_id' => $cartAttribute->product_attr_id ?? null,
                    ];
                }),
                'individual_price' => number_format($individualPrice, 2),
                'final_price' => number_format($finalPrice, 2),
            ];
        });

        return $cartData;
    }



    public function deleteCartItem($userId, $cartItemId)
    {

        return Cart::where('user_identifier', $userId)
            ->where('id', $cartItemId)
            ->delete();
    }





    public function clearCart($userId)
    {
        Cart::where('user_identifier', $userId)->delete();
    }


    public function updateCartItem(array $data)
    {
        try {


            $cartId = $data['cart_id'];
            $quantity = $data['quantity'] ?? 0;
            $attributeValues = $data['attribute_values'] ?? [];

            DB::transaction(function () use ($cartId, $quantity, $attributeValues) {
                $cart = Cart::findOrFail($cartId);
                $productId = $cart->product_id;



                // Check if the product has attributes
                $hasAttributes = ProductAttribute::where('product_id', $productId)->exists();

                if ($hasAttributes) {
                    // Handle products with attributes
                    if (empty($attributeValues)) {

                        $attributeValues = CartAttribute::where('cart_id', $cartId)
                            ->pluck('attribute_options_id')
                            ->toArray();

                        if (empty($attributeValues)) {

                            throw new \Exception("Attribute values are required for updating cart items.");
                        }
                    }

                    $attributeHash = md5(json_encode($attributeValues));


                    $attributesStock = ProductAttribute::where('product_id', $productId)
                        ->whereIn('attribute_option_id', $attributeValues)
                        ->pluck('quantity', 'attribute_option_id');



                    if ($attributesStock->isEmpty()) {

                        throw new \Exception("No stock found for the provided attribute options.");
                    }

                    $currentCartQuantities = Cart::join('cart_attributes', 'carts.id', '=', 'cart_attributes.cart_id')
                        ->where('carts.product_id', $productId)
                        ->where('carts.id', $cartId)
                        ->groupBy('cart_attributes.attribute_options_id')
                        ->selectRaw('cart_attributes.attribute_options_id, SUM(carts.quantity) as total_quantity')
                        ->pluck('total_quantity', 'attribute_options_id');



                    foreach ($attributeValues as $attributeOptionId) {
                        $availableStock = $attributesStock[$attributeOptionId] ?? 0;
                        $existingQuantity = $currentCartQuantities[$attributeOptionId] ?? 0;
                        $newTotalQuantity = $existingQuantity + $quantity;

                        // Log::info('Stock Check', [
                        //     'attribute_option_id' => $attributeOptionId,
                        //     'available_stock' => $availableStock,
                        //     'existing_quantity' => $existingQuantity,
                        //     'requested_quantity' => $newTotalQuantity,
                        // ]);

                        if ($newTotalQuantity > $availableStock) {
                            // Log::error("Stock check failed", [
                            //     'attribute_option_id' => $attributeOptionId,
                            //     'available_stock' => $availableStock,
                            //     'requested_quantity' => $newTotalQuantity,
                            // ]);
                            throw new \Exception("Not enough stock for attribute option {$attributeOptionId}. Available: {$availableStock}, Requested: {$newTotalQuantity}.");
                        }
                    }

                    $cart->increment('quantity', $quantity);
                    $cart->update(['attribute_hash' => $attributeHash]);
                } else {
                    // Handle products without attributes
                    $productStock = Product::where('id', $productId)->value('quantity');


                    // Validate total quantity
                    $existingCartQuantity = Cart::where('product_id', $productId)->sum('quantity');
                    $newTotalQuantity = $existingCartQuantity + $quantity;

                    Log::info('Stock Check for Product without Attributes', [
                        'existing_quantity' => $existingCartQuantity,
                        'requested_quantity' => $quantity,
                        'new_total_quantity' => $newTotalQuantity,
                        'available_stock' => $productStock,
                    ]);

                    if ($newTotalQuantity > $productStock) {

                        throw new \Exception("Not enough stock for this product. Available: {$productStock}, Requested: {$quantity}.");
                    }

                    // Update cart
                    $cart->increment('quantity', $quantity);

                }
            });
        } catch (\Exception $e) {

            throw $e;
        }
    }






//     public function addToCart(array $data)
// {
//     DB::beginTransaction();

//     try {
//         $userId = $data['user_id'];
//         $productId = $data['product_id'];
//         $quantity = $data['quantity'];
//         $attributeIds = $data['attribute_values'] ?? [];
//         $attributeHash = empty($attributeIds) ? 'default_hash' : md5(serialize($attributeIds));

//         if (!$this->checkStockAvailability($productId, $attributeIds, $quantity, $userId)) {
//             throw new \Exception('Not enough stock available for the requested attributes.');
//         }

//         $cart = Cart::firstOrNew(
//             [
//                 'user_identifier' => $userId,
//                 'product_id' => $productId,
//                 'attribute_hash' => $attributeHash,
//             ],
//             [
//                 'quantity' => 0,
//             ]
//         );

//         $cart->quantity += $quantity;
//         $cart->save();

//         if (!empty($attributeIds)) {
//             $this->addAttributesToCart($cart, $attributeIds);
//         }

//         DB::commit();
//         return $cart;

//     } catch (\Exception $e) {
//         DB::rollBack();

//         throw new \Exception($e->getMessage());
//     }
// }


// public function checkStockAvailability($productId, $attributeIds, $requestedQuantity, $userId)
// {
//     $productId =$productId;
//     $requestedAttributeIds = $attributeIds; // Example: [2, 5, 8]
//     $requestedQuantity = $requestedQuantity; // Default to 1 if quantity not provided

//     // Fetch all product attributes
//     $productAttributes = ProductAttribute::where('product_id', $productId)
//         ->where('status', 'enable')
//         ->get();

//     Log::info('Checking product attributes', [
//         'productId' => $productId,
//         'attributes' => $productAttributes,
//     ]);

//     // Separate attributes into combinations and single attributes
//     $attributesByCombination = $productAttributes->groupBy('combination_id');
//     $singleAttributes = $attributesByCombination->get(null, collect()); // Attributes without a combination_id
//     $combinations = $attributesByCombination->except(null);

//     $matchingCombination = null;

//     // Check for single attributes (no combination_id)
//     if ($singleAttributes->isNotEmpty() && count($requestedAttributeIds) === 1) {
//         $singleAttribute = $singleAttributes->firstWhere('attribute_option_id', $requestedAttributeIds[0]);
//         if ($singleAttribute && $singleAttribute->quantity >= $requestedQuantity) {
//             // Reduce quantity
//             // $singleAttribute->decrement('quantity', $requestedQuantity);
//             Log::info('Single attribute matched and updated', ['attribute' => $singleAttribute]);

//             return response()->json([
//                 'success' => true,
//                 'message' => 'Single attribute matched and quantity updated.',
//                 'attribute' => $singleAttribute,
//             ]);
//         }
//     }

//     // Check for combinations
//     foreach ($combinations as $combinationId => $attributes) {
//         $combinationOptionIds = $attributes->pluck('attribute_option_id')->toArray();

//         Log::info('Checking combination', [
//             'combinationId' => $combinationId,
//             'combinationOptionIds' => $combinationOptionIds,
//             'requestedAttributeIds' => $requestedAttributeIds,
//         ]);

//         // Check if the requested attributes match the combination
//         if (array_diff($requestedAttributeIds, $combinationOptionIds) === []) {
//             // Ensure all attributes in the combination have sufficient quantity
//             $hasSufficientQuantity = $attributes->every(fn($attr) => $attr->quantity >= $requestedQuantity);

//             if ($hasSufficientQuantity) {
//                 // Reduce quantity for all attributes in the combination
//                 // foreach ($attributes as $attr) {
//                 //     $attr->decrement('quantity', $requestedQuantity);
//                 // }
//                 $matchingCombination = $attributes;

//                 Log::info('Combination matched and quantities updated', ['attributes' => $attributes]);

//                 return response()->json([
//                     'success' => true,
//                     'message' => 'Combination matched and quantities updated.',
//                     'combination' => $matchingCombination,
//                 ]);
//             }
//         }
//     }

//     return response()->json([
//         'success' => false,
//         'message' => 'No matching attributes or combinations found, or insufficient quantity.',
//     ]);
// }



public function addToCart(array $data)
{
    DB::beginTransaction();

    try {
        $userId = $data['user_id'];
        $productId = $data['product_id'];
        $quantity = $data['quantity'];
        $attributeIds = $data['attribute_values'] ?? [];
        $attributeHash = empty($attributeIds) ? 'default_hash' : md5(serialize($attributeIds));

        // Update the stock check to account for the new logic with ProductAttribute 'id'
        $stockCheck = $this->checkStockAvailability($productId, $attributeIds, $quantity, $userId);

        if (!$stockCheck['success']) {
            throw new \Exception($stockCheck['message']);
        }

        // If combination exists, we use the attribute_hash to check for cart entries
        $cart = Cart::firstOrNew(
            [
                'user_identifier' => $userId,
                'product_id' => $productId,
                'attribute_hash' => $attributeHash,
            ],
            [
                'quantity' => 0,
            ]
        );

        $cart->quantity += $quantity;
        $cart->save();

        // Add attributes to the cart if they exist
        if (!empty($attributeIds)) {
            $this->addAttributesToCart($cart, $attributeIds);
        }

        DB::commit();
        return $cart;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new \Exception($e->getMessage());
    }
}


public function checkStockAvailability($productId, array $attributeIds, $requestedQuantity, $userId)
{
    try {
        // Validate inputs
        if (!$this->validateStockInputs($productId, $attributeIds, $requestedQuantity)) {
            return $this->createStockResponse(false, 'Invalid input parameters');
        }

        // Get current cart quantity
        $currentCartQuantity = $this->getCurrentCartQuantity($productId, $attributeIds, $userId);
        $totalRequestedQuantity = $requestedQuantity + $currentCartQuantity;

        // Fetch product attributes
        $productAttributes = $this->getProductAttributes($productId);

        // Log stock check initiation
        Log::info('Stock check initiated', [
            'product_id' => $productId,
            'requested_attributes' => $attributeIds,
            'total_quantity_needed' => $totalRequestedQuantity
        ]);

        // If the product has no attributes, directly check stock for the product
        if ($productAttributes->isEmpty()) {
            $productStock = $this->getProductStock($productId);

            if ($productStock >= $totalRequestedQuantity) {
                return $this->createStockResponse(true, 'Stock available');
            } else {
                return $this->createStockResponse(false, 'Insufficient stock for this product');
            }
        }

        // Group attributes by combination status
        $attributeGroups = $this->groupProductAttributes($productAttributes);

        // Check stock based on attribute grouping
        if ($attributeGroups['hasCombinations']) {
            return $this->checkCombinationStock(
                $attributeGroups['combinations'],
                $attributeIds,
                $totalRequestedQuantity
            );
        } else {
            return $this->checkSingleAttributeStock(
                $attributeGroups['singles'],
                $attributeIds,
                $totalRequestedQuantity
            );
        }
    } catch (\Exception $e) {
        Log::error('Stock check failed', [
            'error' => $e->getMessage(),
            'product_id' => $productId
        ]);
        return $this->createStockResponse(false, $e->getMessage());
    }
}


private function validateStockInputs($productId, $attributeIds, $quantity)
{
    return is_numeric($productId)
        && $productId > 0
        && is_array($attributeIds)
        && is_numeric($quantity)
        && $quantity > 0;
}

private function getCurrentCartQuantity($productId, $attributeIds, $userId)
{
    $attributeHash = empty($attributeIds) ? 'default_hash' : md5(serialize($attributeIds));

    return Cart::where([
        'user_identifier' => $userId,
        'product_id' => $productId,
        'attribute_hash' => $attributeHash
    ])->sum('quantity');
}

private function getProductAttributes($productId)
{
    return ProductAttribute::with(['product', 'attributeOption'])
        ->where('product_id', $productId)
        ->where('status', 'enable')
        ->get();
}

private function groupProductAttributes($attributes)
{
    $combinations = $attributes->whereNotNull('combination_id')
        ->groupBy('combination_id');

    return [
        'hasCombinations' => $combinations->isNotEmpty(),
        'combinations' => $combinations,
        'singles' => $attributes->whereNull('combination_id')
    ];
}


private function checkCombinationStock($combinations, $requestedAttributeIds, $totalQuantity)
{
    foreach ($combinations as $combinationId => $attributes) {
        // Pluck the 'id' of the ProductAttribute model's attributes (not attribute_option_id)
        $combinationOptionIds = $attributes->pluck('id')->toArray();

        // Check if all requested attribute IDs are present in this combination's attribute 'id's
        if (empty(array_diff($requestedAttributeIds, $combinationOptionIds))) {
            // Check if all attributes have sufficient quantity
            $sufficientStock = $attributes->every(
                fn($attr) => $attr->quantity >= $totalQuantity
            );

            if ($sufficientStock) {
                return $this->createStockResponse(true, 'Stock available', [
                    'combination_id' => $combinationId,
                    'available_quantity' => $attributes->min('quantity')
                ]);
            }
        }
    }

    return $this->createStockResponse(false, 'Insufficient stock for requested combination');
}


private function checkSingleAttributeStock($singleAttributes, $requestedAttributeIds, $totalQuantity)
{
    if ($singleAttributes->isEmpty()) {
        return $this->createStockResponse(false, 'No single attributes found');
    }

    $matchingAttributes = $singleAttributes->whereIn('id', $requestedAttributeIds);

    if (count($requestedAttributeIds) !== $matchingAttributes->count()) {
        return $this->createStockResponse(false, 'Not all requested attributes are available');
    }

    $sufficientStock = $matchingAttributes->every(
        fn($attr) => $attr->quantity >= $totalQuantity
    );

    if ($sufficientStock) {
        return $this->createStockResponse(true, 'Stock available', [
            'available_quantity' => $matchingAttributes->min('quantity')
        ]);
    }

    return $this->createStockResponse(false, 'Insufficient stock for requested attributes');
}

private function createStockResponse($success, $message, $data = [])
{
    return array_merge([
        'success' => $success,
        'message' => $message,
    ], $data);
}


public function getProductStock($productId)
{
    try {
        // Fetch the product from the database
        $product = Product::find($productId);

        if (!$product) {
            throw new \Exception('Product not found');
        }

        // Return the available stock
        return $product->quantity; // Assuming the `stock` column exists in the Product model
    } catch (\Exception $e) {
        Log::error('Failed to fetch product stock', [
            'error' => $e->getMessage(),
            'product_id' => $productId
        ]);
        throw new \Exception('Unable to retrieve product stock');
    }
}





//new
// private function checkStockAvailability($productId, $attributeIds, $requestedQuantity, $userId)
// {
//     // Check if the product has attributes
//     $attributes = ProductAttribute::where('product_id', $productId)->get();
//     Log::info('Checking if product has attributes', [
//         'productId' => $productId,
//         'attributes' => $attributes
//     ]);

//     if ($attributes->isNotEmpty()) {
//         if (empty($attributeIds)) {
//             throw new \Exception('Please select product attributes.');
//         }

//         // Sort attribute IDs to ensure consistent matching
//         sort($attributeIds);

//         // Group attributes by combination_id
//         $attributesByCombination = $attributes->groupBy('combination_id');

//         if (count($attributeIds) === 1) {
//             // Case 1: Single attribute selected
//             $stockData = $attributes->where('attribute_option_id', $attributeIds[0])->first();

//             if (!$stockData) {
//                 throw new \Exception('Stock not found for the selected attribute.');
//             }

//             $availableStock = $stockData->quantity ?? 0; // Default to 0 if quantity is null.
//             Log::info('Single attribute stock check', [
//                 'attributeId' => $attributeIds[0],
//                 'availableStock' => $availableStock,
//             ]);


//             $existingQuantity = $this->getCartQuantityForSingleAttribute($productId, $attributeIds[0], $userId);

//                // Check if combination exists in cart
//                $existingCartItem = Cart::where('product_id', $productId)
//                ->where('user_identifier', $userId)
//                ->first();

//            $newTotalQuantity = $requestedQuantity;
//            if ($existingCartItem) {
//             $newTotalQuantity = $existingQuantity + $requestedQuantity;

//            }else{
//             $newTotalQuantity +=$existingCartItem->quantity;
//            }


//             Log::info('Single attribute check', [
//                 'attributeId' => $attributeIds[0],
//                 'availableStock' => $availableStock,
//                 'existingQuantity' => $existingQuantity,
//                 'newTotalQuantity' => $newTotalQuantity,
//             ]);

//             if ($newTotalQuantity > $availableStock) {
//                 throw new \Exception("Not enough stock for attribute option. Available: {$availableStock}, Requested: {$newTotalQuantity}");
//             }
//         } else {
//             // Case 2: Multiple attributes selected
//             $matchingCombination = null;

//             foreach ($attributesByCombination as $combinationId => $combinationAttributes) {
//                 if ($combinationId === '') continue; // Skip entries without combination_id

//                 // Get all attribute_option_ids for this combination
//                 $combinationOptionIds = $combinationAttributes->pluck('attribute_option_id')->toArray();
//                 sort($combinationOptionIds);

//                 Log::info('Checking combination', [
//                     'combinationId' => $combinationId,
//                     'combinationOptionIds' => $combinationOptionIds,
//                     'requestedAttributeIds' => $attributeIds
//                 ]);

//                 // Check if the requested attributes match this combination exactly
//                 if (empty(array_diff($attributeIds, $combinationOptionIds)) &&
//                     empty(array_diff($combinationOptionIds, $attributeIds))) {
//                     $matchingCombination = $combinationAttributes;
//                     break;
//                 }
//             }

//             Log::info('Matching combination result', ['matchingCombination' => $matchingCombination]);

//             if (!$matchingCombination) {
//                 throw new \Exception('No matching attribute combination found.');
//             }

//             // Use the first item's quantity since all items in a combination should have the same quantity
//             $availableStock = $matchingCombination->first()->quantity ?? 0;
//             $existingQuantity = $this->getCartQuantityForSingleAttribute($productId, $attributeIds[0], $userId);

//                // Check if combination exists in cart
//                $existingCartItem = Cart::where('product_id', $productId)
//                ->where('user_identifier', $userId)
//                ->first();

//            $newTotalQuantity = $requestedQuantity;
//            if ($existingCartItem) {
//             $newTotalQuantity = $existingQuantity + $requestedQuantity;

//            }else{
//             $newTotalQuantity +=$existingCartItem->quantity;
//            }
//             Log::info('Combination attribute check', [
//                 'attributeIds' => $attributeIds,
//                 'availableStock' => $availableStock,
//                 'existingQuantity' => $existingQuantity,
//                 'newTotalQuantity' => $newTotalQuantity,
//             ]);

//             if ($newTotalQuantity > $availableStock) {
//                 throw new \Exception("Not enough stock for the selected attribute combination. Available: {$availableStock}, Requested: {$newTotalQuantity}");
//             }
//         }
//     } else {
//         // Case 3: Products without attributes
//         $productStock = Product::where('id', $productId)->value('quantity');
//         $existingCartQuantity = Cart::where('product_id', $productId)
//             ->where('user_identifier', $userId)
//             ->sum('quantity');

//         $newTotalQuantity = $existingCartQuantity + $requestedQuantity;

//         Log::info('Non-attribute product check', [
//             'productId' => $productId,
//             'productStock' => $productStock,
//             'existingCartQuantity' => $existingCartQuantity,
//             'newTotalQuantity' => $newTotalQuantity,
//         ]);

//         if ($newTotalQuantity > $productStock) {
//             throw new \Exception("Not enough stock for this product. Available: {$productStock}, Requested: {$newTotalQuantity}.");
//         }
//     }

//     return true;
// }






//old
// private function checkStockAvailability($productId, $attributeIds, $requestedQuantity, $userId)
// {
//     // check if the product has attributes
//     $hasAttributes = ProductAttribute::where('product_id', $productId)->exists();

//     if ($hasAttributes) {

//         if (empty($attributeIds)) {
//            throw new \Exception('Please select product attributes. ');

//         }


//         $attributesStock = ProductAttribute::where('product_id', $productId)
//             ->pluck('quantity', 'attribute_option_id');

//         if ($attributesStock->isEmpty()) {
//            throw new \Exception('No stock found for the provided attribute options.');

//         }

//         // Case 1: Single attribute selected (e.g., only size XL)
//         if (count($attributeIds) === 1) {
//             $attributeId = $attributeIds[0];


//             $availableStock = $attributesStock[$attributeId] ?? 0;
//             $existingQuantity = $this->getCartQuantityForSingleAttribute($productId, $attributeId, $userId);

//             $newTotalQuantity = $existingQuantity + $requestedQuantity;


//             if ($newTotalQuantity > $availableStock) {
//                 // Log::error('Not enough stock for attribute', [
//                 //     'attribute_option_id' => $attributeId,
//                 //     'available_stock' => $availableStock,
//                 //     'existing_quantity' => $existingQuantity,
//                 //     'requested_quantity' => $requestedQuantity,
//                 // ]);

//                 throw new \Exception("Not enough stock for attribute option");

//             }
//         } else {

//             $sharedAttributes = $this->getSharedAttributes($attributeIds);
//             $currentCartQuantities = $this->getCartQuantitiesForSharedAttributes($productId, $sharedAttributes, $userId);


//             foreach ($attributeIds as $attributeId) {
//                 $availableStock = $attributesStock[$attributeId] ?? 0;
//                 $existingQuantity = $currentCartQuantities[$attributeId] ?? 0;
//                 $newTotalQuantity = $existingQuantity + $requestedQuantity;

//                 // Check if the requested quantity exceeds the available stock
//                 if ($newTotalQuantity > $availableStock) {
//                     // Log::error('Not enough stock for attribute', [
//                     //     'attribute_option_id' => $attributeId,
//                     //     'available_stock' => $availableStock,
//                     //     'existing_quantity' => $existingQuantity,
//                     //     'requested_quantity' => $requestedQuantity,
//                     // ]);

//                     throw new \Exception("Not enough stock for attribute option");

//                 }
//             }
//         }
//     } else {
//         // Case 3: Products without attributes (e.g., just the product itself)
//         $productStock = Product::where('id', $productId)->value('quantity');
//         $existingCartQuantity = Cart::where('product_id', $productId)
//             ->where('user_identifier', $userId)
//             ->sum('quantity');

//         $newTotalQuantity = $existingCartQuantity + $requestedQuantity;

//         // Validate stock for the product
//         if ($newTotalQuantity > $productStock) {
//             // Log::error('Not enough stock for product', [
//             //     'product_id' => $productId,
//             //     'available_stock' => $productStock,
//             //     'existing_quantity' => $existingCartQuantity,
//             //     'requested_quantity' => $requestedQuantity,
//             // ]);
//             throw new \Exception("Not enough stock for this product. Available: {$productStock}, Requested: {$newTotalQuantity}.");

//         }
//     }

//     return true;
// }

// Helper function to get the shared attributes (e.g., size, XL) from the selected attribute IDs
private function getSharedAttributes($attributeIds)
{

    return $attributeIds;

}

// Helper function to get cart quantities for combinations of selected attributes (e.g., XL, Red)
private function getCartQuantitiesForSharedAttributes($productId, $sharedAttributes, $userId)
{
    // Get all combinations in the cart that include the shared attribute (e.g., size XL)
    return Cart::join('cart_attributes', 'carts.id', '=', 'cart_attributes.cart_id')
        ->where('carts.product_id', $productId)
        ->where('carts.user_identifier', $userId)
        ->whereIn('cart_attributes.attribute_options_id', $sharedAttributes)
        ->groupBy('cart_attributes.attribute_options_id')
        ->selectRaw('SUM(carts.quantity) as total_quantity, cart_attributes.attribute_options_id')
        ->pluck('total_quantity', 'cart_attributes.attribute_options_id');
}

// Helper function to get the cart quantity for a specific product and attribute combination
private function getCartQuantityForSingleAttribute($productId, $attributeId, $userId)
{
    return Cart::join('cart_attributes', 'carts.id', '=', 'cart_attributes.cart_id')
        ->where('carts.product_id', $productId)
        ->where('carts.user_identifier', $userId)
        ->where('cart_attributes.attribute_options_id', $attributeId)
        ->sum('carts.quantity');
}



private function addAttributesToCart($cart, array $attributeIds)
{
    // Filter and ensure valid attribute IDs
    $validAttributeIds = array_filter($attributeIds, function ($id) {
        return !is_null($id) && $id !== '';
    });

    if (empty($validAttributeIds)) {
        throw new \Exception('No valid attributes provided.');
    }

    // Prepare attributes data for bulk insertion
    $attributesData = collect($validAttributeIds)->map(function ($productAttributeId) use ($cart) {
        // Find the corresponding ProductAttribute using the provided product_attribute_id
        $productAttribute = ProductAttribute::find($productAttributeId); 

        if (!$productAttribute) {
            throw new \Exception("Product attribute with ID {$productAttributeId} not found.");
        }

        // Get the related attribute_option_id from ProductAttribute (assuming the relationship is set correctly)
        $attributeOptionId = $productAttribute->attribute_option_id;
        $product_attr_id = $productAttribute->id;

        if (!$attributeOptionId) {
            throw new \Exception("No attribute option associated with Product Attribute ID {$productAttributeId}");
        }

        return [
            'cart_id' => $cart->id,
            'attribute_options_id' => $attributeOptionId, // Store the attribute_option_id
            'product_attr_id' => $product_attr_id, // Store the attribute_option_id
        ];
    })->toArray();

    // Insert or update attributes in CartAttribute table
    CartAttribute::upsert($attributesData, ['cart_id', 'attribute_options_id','product_attr_id']);
}

    // private function addAttributesToCart($cart, array $attributeIds)
    // {
    //     // Filter and ensure valid attribute IDs
    //     $validAttributeIds = array_filter($attributeIds, function ($id) {
    //         return !is_null($id) && $id !== '';
    //     });

    //     if (empty($validAttributeIds)) {

    //         throw new \Exception('No valid attributes provided.');

    //     }

    //     // Prepare attributes data for bulk insertion
    //     $attributesData = collect($validAttributeIds)->map(function ($attributeId) use ($cart) {
    //         return [
    //             'cart_id' => $cart->id,
    //             'attribute_options_id' => $attributeId,
    //         ];
    //     })->toArray();


    //     // Insert or update attributes
    //     CartAttribute::upsert($attributesData, ['cart_id', 'attribute_options_id']);


    // }


}

<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\CouponProduct;
use App\Models\CourierSetting;
use App\Models\Incomplete;
use App\Models\Notification;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductAttribute;

use App\Services\Admin\Comment\CommentService;
use App\Services\Admin\Order\OrderService;
use App\Services\Admin\Order\OrderServiceInterface;
use App\Services\Admin\Pos\POSServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

//use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Services\Admin\CouriarApiSetting\CouriarApiSettingServiceInterface;



class ManageOrdersController extends Controller
{



    protected $orderService, $commentService, $posService, $orderservices,$courierApiSettingService;

    public function __construct(OrderServiceInterface $orderService, CommentService $commentService, POSServiceInterface $posService, OrderService $orderservices,CouriarApiSettingServiceInterface $courierApiSettingService)
    {
        $this->orderService = $orderService;
        $this->commentService = $commentService;
        $this->posService = $posService;
        $this->orderservices = $orderservices;
        $this->courierApiSettingService = $courierApiSettingService;
    }


    public function index(Request $request)
    {

      $orders = $this->orderService->getAllOrder();

        $comments = $this->commentService->all();

        $couriar_settings = CourierSetting::first();

        $orderCounts = $this->orderService->getOrderCounts();

     $filters = $request->only([
            'product_code',
            'invoice',
            'phone',
            'status',
            'customer_name',
            'date_from',
            'date_to',
            'day',
        ]);

        $orders = $this->orderService->getFilteredOrders($filters)->whereNotIn('order_status','incomplete')->sortByDesc('id'); // For collections('id', 'desc'); // Order by 'id' in descending order


        return view('admin.orders.index', [
            'orders' => $orders,
            'comments' => $comments,
            'couriar_settings' => $couriar_settings,
            'total_order' => $orderCounts['total'],
            'pending_order' => $orderCounts['pending'],
            'processed_order' => $orderCounts['processed'],
            'shipped_order' => $orderCounts['shipped'],
            'delivered_order' => $orderCounts['delivered'],
            'cancelled_order' => $orderCounts['cancelled'],
            'returned_order' => $orderCounts['returned'],
            'on_delivary' => $orderCounts['on_delivery'],
        ]);
    }

    public function incompelete()
    {
        // Get all orders
        $orders = $this->orderService->getAllOrder();

        // Filter the orders where 'order_status' is 'incomplete'
        $orders = $orders->filter(function ($order) {
            return $order['order_status'] === 'incomplete';
        });

        // Fetch comments if needed
        $comments = $this->commentService->all();

        // Pass the filtered orders to the view
        return view('admin.orders.incomplete', compact('orders', 'comments'));
    }


    public function duplicate()
    {
        // Get all orders
        $orders = $this->orderService->getAllOrder();

        // Define the specific phone number to check for duplicates
        $targetPhoneNumber = '01745010963';

        // Filter orders to include only those matching the target phone number
        $orders = $orders->filter(function ($order) use ($targetPhoneNumber) {
            return $order['phone_number'] === $targetPhoneNumber;
        });

        // Check if there are duplicates for the specific phone number
        if ($orders->count() <= 1) {
            $orders = collect(); // No duplicates, return an empty collection
        }

        // Fetch comments if needed
        $comments = $this->commentService->all();

        // Pass the filtered duplicate orders to the view
        return view('admin.orders.incomplete', compact('orders', 'comments'));
    }



    public function yourorder(Request $request)
    {
        // Get the authenticated user's ID or the provided user_id
        $user_id = Auth::user()->id ?? $request->user_id;

        // Fetch all orders
        $orders = $this->orderService->getAllOrder();

        // Filter orders by the given user ID
        $filteredOrders = $this->filterOrdersByUserId($orders, $user_id);

        // Check if there are no orders for the user
        if (empty($filteredOrders)) {
            return ApiResponse::success([], 'No orders found for this user.');
        }

        // Fetch comments (if needed)
        $comments = $this->commentService->all();

        // Return the filtered orders with a success message
        return ApiResponse::success($filteredOrders, 'Get Order successfully');
    }






    function filterOrdersByUserId($orders, $userId)
    {
        // Convert the Eloquent Collection to an array if it's not already an array
        $ordersArray = $orders instanceof \Illuminate\Support\Collection ? $orders->toArray() : $orders;

        // Apply array_filter to the array
        return array_filter($ordersArray, function ($order) use ($userId) {
            return $order['customer_info']['id'] == $userId;
        });
    }






    public function orderComment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'comment_id' => 'required|integer',
        ]);

        // Assuming the service method updates the order comment
        $order = $this->orderService->updateOrderComment($request->order_id, $request->comment_id);

        // Return a JSON response for AJAX success
        return response()->json([
            'success' => true,
            'message' => 'Comment has been updated successfully.',
        ]);
    }
    public function ordercommentadd(Request $request)
    {
        $comment = Comment::create($request->all());
           // Assuming the service method updates the order comment
           $order = $this->orderService->updateOrderComment($request->order_id, $comment->id);

           // Return a JSON response for AJAX success
           return response()->json([
               'success' => true,
               'message' => 'Comment has been updated successfully.',
               'data' => Comment::all(),
           ]);
      
    }

    public function ordernote(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'note' => 'required|string',
        ]);

        // Assuming the service method updates the order note
        $order = $this->orderService->updateOrderNote($request->order_id, $request->note);

        // Return a JSON response for AJAX success
        return response()->json([
            'success' => true,
            'message' => 'Order Note has been updated successfully.',
        ]);
    }






    public function checkout(Request $request)
    {

        try {
            $data = $request->all();
            $data['user'] = User::find($data['user_id']);

            if (!$data['user']) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $order = $this->orderService->checkout($data);
             // Create a notification for the new order
       Notification::create([
            'user_id' => $data['user_id'], // The user associated with the order
            'notification_type' => 'Order',
            'related_id' => $order->id, // The ID of the new order
            'message' => "A new order #{$order->id} has been placed successfully.",
        ]);

            return response()->json(['succcess' => $order], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function apiorderfilter(Request $request)
    {
        try {
            // Check if the 'key' parameter is provided
            if (!$request->has('key') || empty($request->key)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Filter key is required.'
                ], 400);
            }

            // Get the filter key from the request
            $filterKey = $request->key;

            // Build the query to search by invoice number or phone number
            $orders = Order::with([
                'customer_info',
                'customer_address',
                'items.product_info',
                'items.option',
                'items.option.attributeOption',
                'items.option.attributeOption.attribute',
                'comment'
            ])
                // Filter by invoice number or phone number
                ->when($filterKey, function ($query) use ($filterKey) {
                    return $query->where('invoice_number', $filterKey)
                        ->orWhereHas('customer_info', function ($subQuery) use ($filterKey) {
                            $subQuery->where('phone_number',  $filterKey);
                        });
                })
                // Execute the query
                ->get();

            // Check if no orders are found
            if ($orders->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No orders found for the given filter.'
                ], 404);
            }

            // Return the filtered data as JSON
            return response()->json([
                'status' => 'success',
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function apicheckout(Request $request)
    {

        $incomplete_id = $request->incomplete_order_id;

        try {
            $data = $request->all();
            $data['user'] = User::find($data['user_id']);

            if (!$data['user']) {
                $data['user'] = $request->user_id;
            }

            $order = $this->orderService->checkout($data);
            $items = $request->items;

            // Fetch detailed product information for each item
            $detailedItems = collect($items)->map(function ($item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    return [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'individual_price' => $item['individual_price'],
                        'total' => $item['total'],
                        'attributeOptionId' => $item['attributeOptionId'],
                        'campaign_discount' => $item['campaign_discount'],
                        'coupon_discount' => $item['coupon_discount'],
                        'original_price' => $item['original_price']
                    ];
                }
                return $item;
            });

            // Add items to the order object
            $order->items = $detailedItems;



            order::where(['id' => $incomplete_id, 'order_status' => 'incomplete'])->delete();
            // Create a notification for the new order only if the order is not incomplete
            if ($order->order_status !== 'incomplete') {
                Notification::create([
                    'user_id' => $data['user_id'], // The user associated with the order
                    'notification_type' => 'Order',
                    'related_id' => $order->id, // The ID of the new order
                    'message' => "A new order #{$order->id} has been placed successfully.",
                ]);
            }


            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }





    public function apiincomplete(Request $request)
    {
        // Validate only the phone number
        $validated = $request->validate([
            'userDetails.phone' => 'required|string|max:15',
        ]);

        try {
            // Extract user details
            $userDetails = $request->input('userDetails', []);
            $phoneNumber = $userDetails['phone'];

            // Save address if provided
            $address = $userDetails['address'];


            // Prepare order items
            $orderItems = array_map(function ($item) {
                return [
                    'product_id' => $item['product_id'] ?? null,
                    'quantity' => $item['quantity'] ?? 1,
                    'price' => $item['price'] ?? 0.00,
                    'campaign_id' => $item['campaign_id'] ?? null,
                    'discount_value' => $item['discount_value'] ?? null,
                ];
            }, $request->input('items', []));

            // Create the incomplete order
            $incompleteOrder = Incomplete::create([
                'user_identifier' => $userDetails['id'] ?? 0,
                'customer_name' => $userDetails['name'] ?? 'Unknown',
                'address' => $address ? $address : null,
                'phone_number' => $phoneNumber,
                'email' => $userDetails['email'] ?? 'Unknown',
                'alternative_phone_number' => $userDetails['alternativePhone'] ?? null,
                'note' => $request->input('note', null),
                'order_status' => 'incomplete',
                'total_price' => array_reduce($orderItems, fn($carry, $item) => $carry + ($item['quantity'] * $item['price']), 0),
                'delivery' => $request->input('area', 'unknown'),
                'invoice_number' => 'INV' . time(),
                'comment_id' => null,
                'order_items' => $orderItems,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Incomplete order created successfully',
                'data' => $incompleteOrder,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create incomplete order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }





    public function validateCoupon(Request $request)
    {

        $couponCode = $request->coupon_code;
        $productIds = $request->product_ids;

        if (empty($productIds)) {
            return response()->json(['error' => 'Product IDs cannot be empty'], 400);
        }

        $coupon = Coupon::where('code', $couponCode)->first();
        if (!$coupon) {
            return response()->json(['error' => 'Coupon not found'], 404);
        }



        if ($coupon->expiry_date < Carbon::now()) {
            return response()->json(['error' => 'Coupon is expired'], 410);
        }

        if ($coupon->usage_limit <= $coupon->used_count) {
            return response()->json(['error' => 'Coupon usage limit exceeded'], 403);
        }

        $couponProduct = CouponProduct::where('coupon_id', $coupon->id)
            ->whereIn('product_id', $productIds)
            ->first();
        if (!$couponProduct) {
            return response()->json(['error' => 'Coupon is not valid for the selected products'], 400);
        }

        return response()->json(['success' => $coupon], 200);



    }


    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,processed,shipped,delivered,cancelled,returned',
        ]);

        // Fetch the orders to update their status and handle the quantity update
        $orders = Order::with('items')->whereIn('id', $request->order_ids)->get();

        foreach ($orders as $order) {
            // Update the order status
            $order->update(['order_status' => $request->status]);

            // Handle quantity update for "cancelled" or "returned" status
            if (in_array($request->status, ['cancelled', 'returned'])) {
                foreach ($order->items as $orderItem) {
                    $product = Product::find($orderItem->product_id);
                    if ($product) {

                        $product->quantity += $orderItem->quantity;
                        $product->save();
                    }
                }
            }
        }

        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
        ]);

        // Fetch the orders to delete and ensure cascading deletes for related items
        Order::with('items')->whereIn('id', $request->order_ids)->delete();



        return response()->json(['success' => true, 'message' => 'Orders deleted successfully.']);
    }

    public function edit($id, Request $request)
    {


        $orders = Order::where('id', $id)->with('customer_info', 'customer_address', 'items', 'items.product_info',  'items.option', 'items.option.attributeOption', 'items.option.attributeOption.attribute', 'comment')->first();

        $product_attribute_data = OrderItem::with('product_attributes', 'product_attributes.attribute', 'product_attributes.attribute_option')->where('order_id', $id)->get();

        // Fetch courier API settings
        $couriar_settings = CourierSetting::first();
        $pathao_couriar_settings = ApiToken::first();

        // Check if 'pathao' is enabled
        $pathao_city = [];

            // Call Pathao functions
           $pathao_cities_response = $this->courierApiSettingService->getCityList();
            $pathao_city = $pathao_cities_response['data']['data'] ?? [];


        // Get all orders
        $order = $this->orderService->getAllOrder();

        // Define the specific phone number to check for duplicates
        $targetPhoneNumber = $orders->phone_number;

        // Filter orders to include only those matching the target phone number
        $duplicateorders = $order->filter(function ($order) use ($targetPhoneNumber) {
            return $order['phone_number'] === $targetPhoneNumber;
        });

        // Check if there are duplicates for the specific phone number
        if ($duplicateorders->count() <= 1) {
            $duplicateorders = collect();
        }

        // Fetch comments if needed
        $comments = $this->commentService->all();




    Cache::forget('top_ordered_products');
    Cache::remember('top_ordered_products', 60, function ()  {
        return Product::query()
            ->select(
                'products.id',
                'products.product_name',
                'products.price',
                'products.slug',
                'products.featured_image',
                DB::raw('COUNT(order_items.id) as order_count')
            )
            ->with([
                'category',
                'productAttributes.attribute',
                'productAttributes.attributeOption',
                'productCampaign',
            ])
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy(
                'products.id',
                'products.product_name',
                'products.price',
                'products.slug',
                'products.featured_image'
            )
            ->orderByDesc('order_count')

            ->get();
    });


     $products = Cache::get('top_ordered_products');

  //  $products = $this->posService->getAllProducts($request->all());



       $redux =   $this->courierApiSettingService->getArea()['areas'] ?? [];



      return view('admin.orders.edit', compact('orders', 'duplicateorders', 'product_attribute_data', 'pathao_city', 'comments', 'couriar_settings', 'products','redux','pathao_couriar_settings'));
    }




    public function show($id)
    {


        $invoice = $this->orderService->getInvoice($id);
        $duplicateorders = Order::where('phone_number', $invoice->phone_number)->get();
        $comments = $this->commentService->all();


        return view('admin.invoice.show', compact('invoice','duplicateorders','comments'));
    }







    public function updateStatus(Request $request)
    {
        // Validate incoming request with updated status options
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',  // Validates that the order exists
            'status' => 'required|in:pending,processed,returned,delivered,cancelled,shipped,on delivery,pending delivery,incomplete',
        ]);

        // Find the order and update its status
        $order = Order::find($request->order_id);
        $order->order_status = $request->status;
        $order->save();

        if ($request->status == 'cancelled' || $request->status == 'returned') {
            foreach ($order->items as $data) {
                // Find the associated product
                $product = Product::find($data->product_id);

                // Ensure the product exists
                if ($product) {

                    $product->quantity += $data->quantity;
                    $product->save();
                }
            }
        }


        return response()->json(['success' => true, 'message' => 'Order status updated']);
    }



    public function getZones($city_id)
    {
        try {

            $zonesResponse = $this->courierApiSettingService->getZones($city_id);

            $zones = $zonesResponse['data']['data'] ?? [];

            return response()->json([
                'success' => true,
                'zones' => $zones
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching zones: ' . $e->getMessage()
            ]);
        }
    }

    public function getAreas(Request $request)
    {
        $zoneId = $request->input('zone_id');

        $areas = $this->courierApiSettingService->getAreas($zoneId);

        return response()->json($areas['data']['data'] ?? []);
    }


    public function orderInfoUpdate(Request $request)
{
    try {
        // Initialize common order data
        $orderData = [
            'customer_name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone,
            'alternative_phone_number' => $request->alternativephone,
            'order_status' => $request->order_status,
            'note' => $request->note ?? '',
            'courier_note' => $request->courier_note ?? '',
            'couriar_name' => $request->courier ?? '',
        ];

        // Handle courier-specific logic
        switch ($request->courier) {
            case 'redx':
                $orderData['area_id'] = $request->redex_zone;
                $orderData['area_name'] = $request->redex_area ?? '';

                $orderData['city_id'] = '';
                $orderData['zone_id'] = '';
                $orderData['city_name'] = '';
                $orderData['zone_name'] = '';



                break;

            case 'pathao':

                $citiesResponse = $this->courierApiSettingService->getCityList();
                $cities = collect($citiesResponse['data']['data']);
                $city = $cities->where('city_id', $request->city)->first();

                if (!$city) {
                    return redirect()->back()->with('error', 'City not found for Pathao courier.');
                }

                $zonesResponse = $this->courierApiSettingService->getZones((int) $city['city_id']);
                $zones = collect($zonesResponse['data']['data']);
                $zone = $zones->where('zone_id', $request->zone)->first();

                $areasResponse = $this->courierApiSettingService->getAreas((int) $zone['zone_id']);
                $areas = collect($areasResponse['data']['data']);
                $area = $areas->where('area_id', $request->area)->first();

                $orderData = array_merge($orderData, [
                    'city_id' => $city['city_id'],
                    'zone_id' => $zone['zone_id'],
                    'area_id' => $area['area_id'],
                    'city_name' => $city['city_name'] ?? '',
                    'zone_name' => $zone['zone_name'] ?? '',
                    'area_name' => $area['area_name'] ?? '',
                ]);

                Log::info('Updating order for Pathao courier:', ['order_id' => $request->order_id, 'data' => $orderData]);
                break;

            case 'steadfast':

                break;

            default:
                break;
        }

        // Update the order in the database
        Order::where('id', $request->order_id)->update($orderData);


        return redirect()->back()->with('success', 'Order updated successfully.');
    } catch (\Exception $e) {

        return redirect()->back()->with('error', 'An error occurred while updating the order.');
    }
}



    private function updateAttributesForOrderItem($orderItem, $attributes, $newQuantity)
    {
        // Fetch all existing options for the order item
        $existingOptions = OrderItemOption::where('order_item_id', $orderItem->id)->get();
        $existingOptionsMap = $existingOptions->keyBy('attribute_options_id');

        // Keep track of processed options
        $processedOptions = [];

        // Process new or updated attributes
        foreach ($attributes as $attributeOptionId) {
            try {
                $existingOption = $existingOptionsMap->get($attributeOptionId);

                if ($existingOption) {
                    // Update existing option
                    $quantityDifference = $newQuantity - $existingOption->quantity;

                    // Adjust stock levels before updating
                    $this->adjustStockLevels(
                        $orderItem->product_id,
                        $attributeOptionId,
                        $quantityDifference
                    );

                    $existingOption->update([
                        'quantity' => $newQuantity,
                        'updated_at' => now()
                    ]);

                    $processedOptions[] = $attributeOptionId;
                } else {
                    // Create new option
                    $this->adjustStockLevels(
                        $orderItem->product_id,
                        $attributeOptionId,
                        $newQuantity
                    );

                    OrderItemOption::create([
                        'order_item_id' => $orderItem->id,
                        'attribute_options_id' => $attributeOptionId,
                        'quantity' => $newQuantity,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    $processedOptions[] = $attributeOptionId;
                }
            } catch (\Exception $e) {

                throw new \Exception("Error processing attribute option ID {$attributeOptionId}: {$e->getMessage()}");
            }
        }

        // Remove outdated options
        foreach ($existingOptions as $existingOption) {
            if (!in_array($existingOption->attribute_options_id, $processedOptions)) {
                try {
                    // Adjust stock levels before deletion
                    $this->adjustStockLevels(
                        $orderItem->product_id,
                        $existingOption->attribute_options_id,
                        -$existingOption->quantity
                    );

                    $existingOption->delete();
                } catch (\Exception $e) {

                    throw new \Exception("Error removing attribute option ID {$existingOption->attribute_options_id}: {$e->getMessage()}");
                }
            }
        }

        return [
            'success' => true,
            'message' => 'Attributes updated successfully',
            'processed_options' => $processedOptions
        ];
    }

    private function adjustStockLevels($productId, $attributeOptionId, $quantityDifference)
    {
        $productAttribute = ProductAttribute::where('product_id', $productId)
            ->where('attribute_option_id', $attributeOptionId)
            ->firstOrFail();

        if ($quantityDifference > 0) {
            if ($productAttribute->quantity < $quantityDifference) {
                throw new \Exception("Insufficient stock for attribute option ID: {$attributeOptionId}");
            }
            $productAttribute->decrement('quantity', $quantityDifference);
            $productAttribute->increment('sold_quantity', $quantityDifference);
        } elseif ($quantityDifference < 0) {
            $adjustment = abs($quantityDifference);
            $productAttribute->increment('quantity', $adjustment);
            $productAttribute->decrement('sold_quantity', $adjustment);
        }
    }



    // update oders method
    public function update(Request $request)
    {
    //   return  $request->all();
        DB::beginTransaction();

        try {
            $data = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.order_item_option_id' => 'required|exists:order_items,id',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.attributes' => 'nullable|array',
                'items.*.attributes.*.attribute_option_id' => 'required_with:items.*.attributes|exists:product_attributes,attribute_option_id',
                'delivery_charge' => 'nullable|numeric|min:0',
                'total_price' => 'required|numeric|min:0',
                'discount' => 'nullable|numeric|min:0',
            ]);

            $order = Order::findOrFail($data['order_id']);
            $discount = $request->discount ?? 0;

            $order->update([
                'delivery_charge' => $data['delivery_charge'] ?? 0,
                'total_price' => $data['total_price'],
                'discount' => $discount,
            ]);



            foreach ($data['items'] as $item) {
                $this->processOrderItem($item);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Order updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order update failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    private function processOrderItem(array $item)
    {
        $orderItem = OrderItem::findOrFail($item['order_item_option_id']);
        $quantityDifference = $item['quantity'] - $orderItem->quantity;

        $orderItem->update([
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);

        if ($quantityDifference !== 0) {
            $this->updateInventory($item, $quantityDifference);
        }
    }

    private function updateInventory(array $item, int $quantityDifference)
    {
        $product = Product::findOrFail($item['product_id']);

        if ($quantityDifference > 0) {
            if ($product->quantity < $quantityDifference) {
                throw new \Exception("Insufficient stock for product: {$product->name}");
            }
            $product->decrement('quantity', $quantityDifference);
            $product->increment('sold_quantity', $quantityDifference);
        } else {
            $product->increment('quantity', abs($quantityDifference));
            $product->decrement('sold_quantity', abs($quantityDifference));
        }

        if (isset($item['attributes']) && is_array($item['attributes'])) {
            foreach ($item['attributes'] as $attribute) {
                $this->updateAttributeStock($product, $attribute, $quantityDifference);
            }
        }
    }

    private function updateAttributeStock(Product $product, array $attribute, int $quantityDifference)
    {
        $productAttribute = ProductAttribute::where('product_id', $product->id)
            ->where('attribute_option_id', $attribute['attribute_option_id'])
            ->whereNotNull('combination_id') // Check if combine_id exists
            ->first();


        if (!$productAttribute) {
            throw new \Exception("Attribute stock not found for product: {$product->name}");
        }

        if ($quantityDifference > 0) {
            if ($productAttribute->quantity < $quantityDifference) {
                throw new \Exception("Insufficient stock for attribute of product: {$product->name}");
            }
            $productAttribute->decrement('quantity', $quantityDifference);
        } else {
            $productAttribute->increment('quantity', abs($quantityDifference));
        }
    }







    //Issue has started

    public function bulkProcess(Request $request)
    {
        $orderIds = $request->input('orders', []);

        if (empty($orderIds)) {
            return response()->json(['message' => 'No orders selected.'], 400);
        }

        // Fetch and process the orders
        $orders = Order::whereIn('id', $orderIds)->with('customer_info', 'customer_address', 'items', 'items.product_info', 'items.option', 'items.option.attributeOption', 'items.option.attributeOption.attribute', 'comment')->get();

        // Store the selected orders in the session
        session(['bulk_orders' => $orders]);

        return response()->json([
            'message' => 'Orders selected successfully.',
            'redirect_url' => route('admin.orders.bulkOrderView')
        ]);
    }

    public function bulkOrderView()
    {

        $orders = session('bulk_orders', []);

        if (empty($orders)) {
            return redirect()->route('admin.orders.index')->with('error', 'No orders selected.');
        }

        session()->forget('bulk_orders');

        $media = getFirstMedia();

        $comments = $this->commentService->all();

        return view('admin.orders.bulk-order.index', compact('orders', 'comments', 'media'));
    }

    public function generatePDF(Request $request)
    {
        $orderIds = $request->input('order_ids');
        if (empty($orderIds)) {
            return response()->json(['error' => 'No orders selected'], 400);
        }

        $orders = Order::whereIn('id', $orderIds)->with('customer_info', 'customer_address', 'items', 'items.product_info', 'items.option', 'items.option.attributeOption', 'items.option.attributeOption.attribute', 'comment')->get();


        // Generate PDF
        $pdf = Pdf::loadView('admin.orders.invoice.index', compact('orders'));


        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="invoices.pdf"');
    }

    public function bulkCSVProcessSteadfast(Request $request)
    {
        $orderIds = $request->input('orders', []);

        if (empty($orderIds)) {
            return response()->json(['message' => 'No orders selected.'], 400);
        }

        // Fetch and process the orders
        $orders = Order::whereIn('id', $orderIds)->with('customer_info', 'customer_address', 'items', 'items.product_info', 'items.option', 'items.option.attributeOption', 'items.option.attributeOption.attribute', 'comment')->get();

        // Store the selected orders in the session
        session(['bulk_orders' => $orders]);

        return response()->json([
            'message' => 'Orders selected successfully.',
            'redirect_url' => route('admin.orders.bulkCSVViewSteadfast')
        ]);
    }


    public function bulkCSVViewSteadfast()
    {

        $orders = session('bulk_orders', []);

        if (empty($orders)) {
            return redirect()->route('admin.orders.index')->with('error', 'No orders selected.');
        }

        session()->forget('bulk_orders');

        $media = getFirstMedia();

        $comments = $this->commentService->all();

        return view('admin.orders.bulk-csv.steadfast', compact('orders', 'comments', 'media'));
    }


    public function delete($id)
    {


        $order = Order::findOrFail($id);

        $order->delete();

        return redirect()->back()->with('success', 'Data deleted successfully');
    }





    public function orderNow(Request $request)
    {

        //return $request->all();

        // Normalize input
        $order = (object) $request->order;
        $item = $request->item;
        $data = $request->data;

        $itemAttr = $item['attributeOptionId'] ?? null;
        if ($itemAttr) {

            if (!is_array($itemAttr)  || !array_filter($itemAttr, fn($value) => $value !== null)) {

                return redirect()->back()->with('error', 'Please select product attribute', 400);
            }
        }

        // Call the service method
        $this->orderservices->processOrderItem($order, $item, $data);


        return redirect()->back()->with('success', 'Order processed successfully');
    }





    public function deleteitem(Request $request)
    {
        $id = $request->input('item_id');
        $quantity = $request->input('quanity');

        if (!$id || !$quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid item ID or quantity provided.',
            ]);
        }

        try {
            $orderItem = OrderItem::findOrFail($id);
            $product = Product::findOrFail($orderItem->product_id);
            $orderItemOptions = OrderItemOption::where('order_item_id', $orderItem->id)->get();

            if ($orderItemOptions->isEmpty()) {

                $product->quantity += $orderItem->quantity;
                $product->save();
            } else {
                // Update product quantity and attributes
                foreach ($orderItemOptions as $option) {
                    $this->updateProductQuantityAndAttributes($product, $option, $quantity);
                }
                $product->quantity += $quantity;
                $product->save();
            }

            $orderItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Item or product not found.',
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the item.',
            ]);
        }
    }


    /**
     * Update the product quantity and handle attributes based on options.
     *
     * @param Product $product
     * @param OrderItemOption $option
     */
    private function updateProductQuantityAndAttributes(Product $product, OrderItemOption $option, $quantity)
    {
        // Retrieve a single matching product attribute
        $productAttribute = ProductAttribute::where('product_id', $product->id)
            ->where('attribute_option_id', $option->attribute_options_id)
            ->whereNotNull('combination_id')
            ->first();

        if ($productAttribute) {
            // Update the product attribute quantity
            $productAttribute->quantity += $quantity;
            $productAttribute->save();
        } else {
          //  Log::warning("No product attributes found for Product ID: {$product->id} and Option ID: {$option->attribute_options_id}");
        }
    }



}

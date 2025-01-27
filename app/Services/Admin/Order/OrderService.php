<?php

namespace App\Services\Admin\Order;

use App\Models\AttributeOption;
use App\Models\Cart;
use App\Models\CartAttribute;
use App\Models\OrderItemOption;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\SiteInfo;
use App\Repositories\Admin\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Repositories\Payment\PaymentRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }





    public function checkout(array $data)
    {

        DB::beginTransaction();
        try {
            $items = $this->validateItems($data['items']);

            if (isset($data["user_name"])) {
                $data["user_name"] = $data["user_name"];
            } else {
                $data["user_name"] = '';
            }

            $user = $this->getUser($data['user_id'], $data["user_name"]);
            $totalPrice = $this->calculateTotalPrice($items);
            $deliveryCharge = $this->getDeliveryCharge($data);
            $paidAmount = $data['paid_amount'] ?? 0;
            //  $orderType = 'checkout'; //testing pos
            $orderType = $data['order_type'] ?? 'pos';
            $diccount = $data['discount'] ?? 0;
            $posdiccount = $data['discounts'] ?? 0;


            $totalOrderAmount = $totalPrice + $deliveryCharge - $diccount - $posdiccount;



            // $siteInfo = SiteInfo::first();
            // if (!$siteInfo) {
            //     throw new \Exception('Site information is missing. Please configure it.');
            // }



            // // Check minimum partial payment when total amount exceeds minimum order amount
            // if ($orderType === 'checkout' && $totalOrderAmount >= $siteInfo->minimum_order_amount) {

            //     if ($paidAmount < $siteInfo->partial_ammount) {

            //         throw new \Exception("For orders above {$siteInfo->minimum_order_amount}, minimum partial payment of {$siteInfo->partial_ammount} is required");
            //     }
            // }

            $remainingBalance = $totalOrderAmount - $paidAmount ?? 0;

            // Create Order
            $invoiceNumber = $this->generateInvoiceNumber();
            $orderData = $this->prepareOrderData(
                $data,
                $user,
                $totalPrice,
                $deliveryCharge,
                $invoiceNumber,
                $remainingBalance,
                $paidAmount,
                $posdiccount
            );



            $order = $this->orderRepository->createOrder($orderData);

            // Process partial payment for orders >= minimum order amount
            // if ($totalOrderAmount >= $siteInfo->minimum_order_amount) {

            //     app(PaymentRepositoryInterface::class)->processPartialPayment($order, $paidAmount, 'bKash');
            // }

            // Process Order Items
            foreach ($items as $item) {
                $this->processOrderItem($order, $item, $data);
            }

            DB::commit();

            // Clear the user's cart
            Cart::where('user_identifier', $user->id)->delete();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Checkout failed: " . $e->getMessage());
        }
    }

    private function Siteinfo()
    {
        return SiteInfo::first();
    }



    private function validateItems($items)
    {
        $items = is_string($items) ? json_decode($items, true) : $items;

        if (!is_array($items) || empty($items)) {
            throw new \Exception('Invalid items data. Expected a non-empty array.');
        }

        foreach ($items as $item) {
            if (
                !isset($item['total'], $item['product_id'], $item['quantity'], $item['individual_price']) ||
                !is_numeric($item['total']) ||
                !is_numeric($item['quantity']) ||
                $item['quantity'] <= 0
            ) {
                throw new \Exception('Each item must have valid total, product_id, and quantity.');
            }
        }

        return $items;
    }

    private function getUser($userId, $userName)
    {
        $user = User::find($userId);

        if (!$user) {
            $email = $userId . '@guest.com';
            $user = User::where('email', $email)->first();
            if (!$user) {
                // Create a new user if not found
                $user = User::create([

                    'name' => $userName,
                    'email' => $userId . '@guest.com',
                    'password' => bcrypt(Str::random(10)),
                ]);
            }
            return $user;
        }

        return $user;
    }

    private function calculateTotalPrice($items)
    {
        return array_reduce($items, function ($total, $item) {
            return $total + $item['total'];
        }, 0);
    }

    private function getDeliveryCharge($data)
    {
        return isset($data['delivery_charge']) && is_numeric($data['delivery_charge'])
            ? $data['delivery_charge']
            : 0;
    }

    private function prepareOrderData($data, $user, $totalPrice, $deliveryCharge, $invoiceNumber, $remainingBalance, $paidAmount, $posdiccount)
    {
        $invoiceNumber = $this->generateInvoiceNumber();


        $phoneNumber = $data['phone_number'];
        $address = $data['address'];




        return [
            'user_identifier' => $user->id,
            'customer_name' => $user->name,
            'address' =>  $address,
            'phone_number' => $phoneNumber,
            'email' => $user->email,
            'order_status' => $data['order_status'] ?? 'pending',
            'total_price' => $totalPrice - ($data['discounts'] ?? 0) - ($data['discount'] ?? 0),
            'shipping_price' => $data['shipping_price'] ?? 0,
            'delivery' => 'N/A',
            'delivery_charge' => $deliveryCharge,
            'order_type' => 'pos',
            'note' => $data['note'] ?? null,
            'invoice_number' => $invoiceNumber,
            'remaining_balance' => $remainingBalance ?? null,
            'paid_amount' => $paidAmount ?? 0,
            'discount' => $posdiccount,


        ];
    }



    public function processOrderItem($order, $item, $data)
    {



        // Get attribute options as array
        $attributeOptionIds = is_array($item['attributeOptionId'])
            ? array_map('trim', $item['attributeOptionId'])
            : array_map('trim', explode(',', (string)$item['attributeOptionId']));




        // Calculate quantity per attribute option
        $requestQuantity = (int)$item['quantity'];
        $numberOfAttributes = count($attributeOptionIds);

        $totalRequestQuantity = $requestQuantity * $numberOfAttributes;


        // Check if the product has attributes
        $product = Product::findOrFail($item['product_id']);



        // Create Order Item
        $orderItem = $this->orderRepository->createOrderItem($order->id, [
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['individual_price'],
            'discount' => $data['discount'] ?? 0,
            'discount_type' => $data['discount_type'] ?? 'fixed',
        ]);

        if (!empty($item['attributeOptionId']) && $item['attributeOptionId'] !== 'N/A') {
            $attributeOptionIds = is_array($item['attributeOptionId'])
                ? $item['attributeOptionId']
                : (is_numeric($item['attributeOptionId'])
                    ? [$item['attributeOptionId']]
                    : explode(',', $item['attributeOptionId']));

            $this->processAttributes($orderItem, $attributeOptionIds, $item['quantity'], $totalRequestQuantity, $data);
        } else {
            // Reduce product quantity
            $product->decrement('quantity',  $totalRequestQuantity);
            $product->increment('sold_quantity',  $totalRequestQuantity);
        }
    }






    private function processAttributes($orderItem, $attributeOptionIds, $quantity, $totalRequestQuantity, $data)
    {
        try {
            // Validate and normalize attribute option IDs
            if (!is_array($attributeOptionIds) && !is_string($attributeOptionIds)) {
                throw new \Exception("Invalid attribute option data. Expected array or string, got: " . gettype($attributeOptionIds));
            }

            $attributeOptionIds = is_string($attributeOptionIds) ? explode(',', $attributeOptionIds) : $attributeOptionIds;
            $attributeOptionIds = array_map('trim', $attributeOptionIds);

            if (!is_array($attributeOptionIds)) {
                throw new \Exception("Attribute option IDs must be an array after processing.");
            }

            $product = Product::findOrFail($orderItem->product_id);

            // Fetch all attributes related to the product
            $productAttributes = ProductAttribute::whereIn('id', $attributeOptionIds)
                ->where('status', 'enable')
                ->get();

            $attributesByCombination = $productAttributes->groupBy('combination_id');
            $singleAttributes = $attributesByCombination->get(null, collect());
            $combinations = $attributesByCombination->except(null);



            // Process single attributes
            if ($singleAttributes->isNotEmpty() && count($attributeOptionIds) === 1) {
                $singleAttribute = $singleAttributes->firstWhere('id', $attributeOptionIds[0]);

                if ($singleAttribute && $singleAttribute->quantity >= $quantity) {
                    // Get attribute_options_id from the mapped data
                    $attributeOptionsId = $optionsByCartId[$orderItem->cart_id] ?? $singleAttribute->attribute_option_id;

                    if (!$attributeOptionsId) {
                        throw new \Exception("Could not determine attribute_options_id for cart_id: {$orderItem->cart_id}");
                    }

                    $orderItemOptionData = [
                        'product_attibute_id' => $attributeOptionIds[0],
                        'attribute_options_id' => $attributeOptionsId,
                        'quantity' => $quantity,
                    ];



                    $this->orderRepository->createOrderItemOption($orderItem->id, $orderItemOptionData);

                    $singleAttribute->decrement('quantity', $quantity);
                    $singleAttribute->increment('sold_quantity', $quantity);

                    $product->decrement('quantity', $totalRequestQuantity);
                    $product->increment('sold_quantity', $totalRequestQuantity);

                    return true;
                }

                throw new \Exception("Insufficient stock for single attribute option ID: {$attributeOptionIds[0]}");
            }

            // Process combinations
            foreach ($combinations as $combinationId => $attributes) {
                $combinationOptionIds = $attributes->pluck('id')->toArray();

                if (array_diff($attributeOptionIds, $combinationOptionIds) === []) {
                    $hasSufficientQuantity = $attributes->every(fn($attr) => $attr->quantity >= $quantity);

                    if ($hasSufficientQuantity) {
                        foreach ($attributes as $attribute) {
                            // Get attribute_options_id from the mapped data or fallback to attribute's option id
                            $attributeOptionsId = $optionsByCartId[$orderItem->cart_id] ?? $attribute->attribute_option_id;

                            if (!$attributeOptionsId) {
                                throw new \Exception("Could not determine attribute_options_id for combination attribute");
                            }

                            $orderItemOptionData = [
                                'product_attibute_id' => $attributeOptionIds[0],
                                'attribute_options_id' => $attributeOptionsId,
                                'quantity' => $quantity,
                            ];

                            Log::info('Creating combination order item option:', $orderItemOptionData);

                            $this->orderRepository->createOrderItemOption($orderItem->id, $orderItemOptionData);

                            $attribute->decrement('quantity', $quantity);
                            $attribute->increment('sold_quantity', $quantity);
                        }

                        $product->decrement('quantity', $totalRequestQuantity);
                        $product->increment('sold_quantity', $totalRequestQuantity);

                        return true;
                    }

                    throw new \Exception("Insufficient stock for one or more attributes in combination ID: {$combinationId}");
                }
            }

            throw new \Exception("No matching attributes or combinations found for the provided options.");
        } catch (\Exception $e) {
            Log::error('Error in processAttributes:', [
                'message' => $e->getMessage(),
                'orderItem' => $orderItem->toArray(),
                'attributeOptionIds' => $attributeOptionIds,
                'data' => $data
            ]);
            throw $e;
        }
    }










    private function generateInvoiceNumber()
    {



        $randomSequence = rand(1000, 9999);

        return "{$randomSequence}";
    }


    public function getInvoice($id)
    {
        return  $this->orderRepository->getInvoice($id);
    }





    public function updateOrder(array $data, $orderId)
    {
        return "hjh";
    }

    public function getAllOrder()
    {
        $orders = $this->orderRepository->getAllOrdersWithDetails();

        return $orders;
    }
    public function getIncompeleteOrder()
    {
        $orders = $this->orderRepository->getincompeleteOrdersWithDetails();

        return $orders;
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getAll();
    }

    public function getOrderCounts()
    {
        return [
            'total' => $this->orderRepository->countAll(),
            'pending' => $this->orderRepository->countByStatus('pending'),
            'processed' => $this->orderRepository->countByStatus('processed'),
            'shipped' => $this->orderRepository->countByStatus('shipped'),
            'delivered' => $this->orderRepository->countByStatus('delivered'),
            'cancelled' => $this->orderRepository->countByStatus('cancelled'),
            'returned' => $this->orderRepository->countByStatus('returned'),
            'on_delivery' => $this->orderRepository->countByStatus('on delivery'),
        ];
    }



    public function updateOrderComment($orderId, $commentId)
    {
        return $this->orderRepository->updateComment($orderId, $commentId);
    }
    public function updateOrdernote($orderId, $orderNote)
    {
        return $this->orderRepository->updateOrderNote($orderId, $orderNote);
    }


    public function getFilteredOrders(array $filters): Collection
    {
        return $this->orderRepository->filterOrders($filters);
    }

    public function getOrderStatistics(): array
    {
        return $this->orderRepository->getOrderCounts();
    }
}

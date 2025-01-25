<?php

namespace App\Repositories\Admin\Order;

use App\Models\Blog;
use App\Models\Incomplete;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(array $orderData)
    {
        return Order::create($orderData);
    }

    public function createOrderItem(int $orderId, array $itemData)
    {
        return OrderItem::create(array_merge($itemData, ['order_id' => $orderId]));
    }

    public function createOrderItemOption(int $orderItemId, array $optionData)
    {
        return OrderItemOption::create(array_merge($optionData, ['order_item_id' => $orderItemId]));
    }

    public function getInvoice($id)
    {
       return Order::with('items.option.attributeOption.attribute')->find($id);
    }

    public function getAllOrdersWithDetails()
    {



      
            $order_data=   Order::with(
                'customer_info',
                'customer_address',
                'items',
                'items.product_info',
                'items.option',
                'items.option.attributeOption',
                'items.option.attributeOption.attribute',
                'comment'
            )->orderBy('created_at', 'desc')->get();


        return $order_data;

    }
    public function getincompeleteOrdersWithDetails()
    {



        // Fetch incomplete orders along with related details
        $order_data = Incomplete::with([


            'customer_info',
            'customer_address',

        ])->get();

        return $order_data;
    }




    public function updateOrder(array $data, $id)
    {
        $order = Order::find($id);
        $order->update($data);
        return $order;
    }


    public function getAll()
    {
        return Order::all();
    }

    public function countByStatus(string $status)
    {
        return Order::where('order_status', $status)->count();
    }

    public function countAll()
    {
        return Order::count();
    }

    public function findById($id)
    {
        return Order::findOrFail($id);
    }

    public function updateComment($orderId, $commentId)
    {
        $order = $this->findById($orderId);
        $order->update([
            'comment_id' => $commentId,
        ]);

        return $order;
    }
    public function updateOrderNote($orderId, $orderNote)
    {
        $order = $this->findById($orderId);
        $order->update([
            'note' => $orderNote,
        ]);

        return $order;
    }

    // order fillter
    public function filterOrders(array $filters): Collection
    {
        // Extract filters from the passed array
        $productCode = $filters['product_code'] ?? null;
        $invoice = $filters['invoice'] ?? null;
        $phone = $filters['phone'] ?? null;
        $customerName = $filters['customer_name'] ?? null;
        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;
        $status = $filters['status'] ?? null;
        $day = $filters['day'] ?? null;

        $orders = Order::with([
            'customer_info',
            'customer_address',
            'items.product_info',
            'items.option',
            'items.option.attributeOption',
            'items.option.attributeOption.attribute',
            'comment'
        ])
        // Filter by product code if provided
        ->when($productCode, function ($query) use ($productCode) {
            return $query->whereHas('items.product_info', function ($subQuery) use ($productCode) {
                $subQuery->where('product_code', $productCode);
            });
        })
        // Filter by invoice number if provided
        ->when($invoice, function ($query) use ($invoice) {
            return $query->where('invoice_number', 'like', '%' . $invoice . '%');
        })
        // Filter by phone number if provided
        ->when($phone, function ($query) use ($phone) {
            return $query->where('phone_number', 'like', '%' . $phone . '%');
        })
        // Filter by customer name if provided
        ->when($customerName, function ($query) use ($customerName) {
            return $query->whereHas('customer_info', function ($subQuery) use ($customerName) {
                $subQuery->where('name', 'like', '%' . $customerName . '%');
            });
        })
        // Filter by date range if provided
        ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
            return $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        })
        // Filter by only 'date_from' or 'date_to'
        ->when($dateFrom, function ($query) use ($dateFrom) {
            return $query->where('created_at', '>=', $dateFrom);
        })
        ->when($dateTo, function ($query) use ($dateTo) {
            return $query->where('created_at', '<=', $dateTo);
        })
        // Filter by status if provided
        ->when($status, function ($query) use ($status) {
            return $query->where('order_status', $status);
        })
        ->when($status, function ($query) use ($status) {
            return $query->where('couriar_name', $status);
        })
        // Filter by day if provided
        ->when($day, function ($query) use ($day) {
            $currentDate = now();
            switch ($day) {
                case 1: // Today
                    return $query->whereDate('created_at', $currentDate->toDateString());
                case 2: // Yesterday
                    return $query->whereDate('created_at', $currentDate->subDay()->toDateString());
                case 3: // Last 7 days
                    return $query->where('created_at', '>=', $currentDate->subDays(7)->toDateString());
                case 4: // Last 30 days
                    return $query->where('created_at', '>=', $currentDate->subDays(30)->toDateString());
                case 5: // This month
                    return $query->whereMonth('created_at', $currentDate->month)
                        ->whereYear('created_at', $currentDate->year);
                case 6: // Last month
                    return $query->whereMonth('created_at', $currentDate->subMonth()->month)
                        ->whereYear('created_at', $currentDate->year);
                default:
                    return $query;
            }
        })
        ->get();  // Retrieve the orders

        return $orders;
    }


    public function getOrderCounts(): array
    {

        return [
            'total' => Order::count(),
            'pending' => Order::where('order_status', 'pending')->count(),
            'processed' => Order::where('order_status', 'processed')->count(),
            'shipped' => Order::where('order_status', 'shipped')->count(),
            'delivered' => Order::where('order_status', 'delivered')->count(),
            'cancelled' => Order::where('order_status', 'cancelled')->count(),
            'returned' => Order::where('order_status', 'returned')->count(),
            'on_delivery' => Order::where('order_status', 'on delivery')->count(),
        ];
    }

}

<?php

namespace App\Repositories\Admin\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function createOrder(array $orderData);
    public function createOrderItem(int $orderId, array $itemData);
    public function createOrderItemOption(int $orderItemId, array $optionData);

    public function getInvoice($id);

    public function getAllordersWithDetails();
    public function getincompeleteOrdersWithDetails();

    public function updateOrder(array $data, $id);
    public function getAll();
    public function countByStatus(string $status);
    public function countAll();


    public function findById($id);
    public function updateComment($orderId, $commentId);
    public function updateOrderNote($orderId, $orderNote);

    // order fillter
    public function filterOrders(array $filters): Collection;
    public function getOrderCounts(): array;

}

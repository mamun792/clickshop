<?php

namespace App\Services\Admin\Order;

use Illuminate\Support\Collection;

interface OrderServiceInterface
{



    public function checkout(array $data);

    public function getInvoice($id);

    public function getAllOrder();
    public function getIncompeleteOrder();

   public function updateOrder(array $data, $id);
   public function getOrderCounts();

//  public function deleteOrder($id);

    public function updateOrderComment($orderId, $commentId);
    public function updateOrdernote($orderId, $orderNote);

   // oder fillter
   public function getFilteredOrders(array $filters): Collection;

   public function getOrderStatistics(): array;


}

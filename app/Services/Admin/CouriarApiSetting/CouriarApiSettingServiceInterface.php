<?php

namespace App\Services\Admin\CouriarApiSetting;
use App\Models\Order;
use Illuminate\Http\Request;

interface CouriarApiSettingServiceInterface
{
    public function storeOrUpdate($request);
    public function get();

    public function prepareOrderData(Order $order): array;
    public function sendOrderToCourier(array $orderData): array;

    public function   generateApiToken(Request $request);

    public function getCityList();

     public function  getZones($id);

   public function    getAreas($zoneId);

   public function sendOrderToPathaoCourier($order,  $itemQuantity);

   public function sendBulkOrders(array $orders, string $accessToken): array;

   // redx
   public function getArea();
   public function getCity($request);
   public function createParcel(array $data);



}

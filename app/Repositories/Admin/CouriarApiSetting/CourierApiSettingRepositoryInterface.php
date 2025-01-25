<?php

namespace App\Repositories\Admin\CouriarApiSetting;

interface CourierApiSettingRepositoryInterface
{
    public function storeOrUpdate($request);
    public function get();

    public function sendOrder(array $orderData): ?array;

    public function saveApiToken(array $attributes);

    public function getAccessToken();


   // redx
   public function getTokens();

}

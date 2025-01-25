<?php

namespace App\Services\Admin\Manage_site;

use App\Models\SiteInfo;

interface SiteServiceInterface
{
    public function storeOrUpdateSite(array $data): SiteInfo;
    public function getSiteInfo();
    public function getDeliveryCharge():array;
   
}
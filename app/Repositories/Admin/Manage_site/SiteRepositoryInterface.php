<?php

namespace App\Repositories\Admin\Manage_site;


use App\Models\SiteInfo;

interface SiteRepositoryInterface
{
    public function storeOrUpdateSite(array $data): SiteInfo;
    public function getSiteInfo();
    public function getDeliveryCharge(): array;
   
}
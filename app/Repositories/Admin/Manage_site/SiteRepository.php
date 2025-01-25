<?php

namespace App\Repositories\Admin\Manage_site;

use App\Models\SiteInfo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SiteRepository implements SiteRepositoryInterface
{
    public function storeOrUpdateSite(array $data, bool $refreshCache = false): SiteInfo
    {

       $site=  SiteInfo::updateOrCreate(
            ['id' => 1],
            $data
        );

        // Invalidate cache for updated keys
        foreach ($data as $key => $value) {
            Cache::forget("site_info_{$key}");
            if ($refreshCache) {
                Cache::remember("site_info_{$key}", now()->addHours(24), fn() => $value);
            }
        }


        return $site;
    }


    public function getSiteInfo()
    {

         return SiteInfo::all();

    }

    public function getDeliveryCharge(): array
    {
        $siteInfo = $this->getSiteInfo()->first();

        return [
            'inside_dhaka' => $siteInfo->shipping_charge_inside_dhaka ?? null,
            'outside_dhaka' => $siteInfo->shipping_charge_outside_dhaka ?? null,
            'quantity_indicator'=>$siteInfo->quantity_indicator ?? null,
        ];
    }

}

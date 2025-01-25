<?php

namespace App\Services\Admin\Manage_site;

use App\Models\SiteInfo;
use App\Repositories\Admin\Manage_site\SiteRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use  Illuminate\Support\Facades\Cache;

class SiteService implements SiteServiceInterface
{

    protected $siteRepository;

    public function __construct(SiteRepositoryInterface $siteRepository)
    {
        $this->siteRepository = $siteRepository;
    }

    public function storeOrUpdateSite(array $data): SiteInfo
    {
        return $this->siteRepository->storeOrUpdateSite($data);
    }

    public function getSiteInfo()
    {
        return $this->siteRepository->getSiteInfo();
    }

    public function getDeliveryCharge(): array
    {
        return $this->siteRepository->getDeliveryCharge();
    }



    public function get($key)
    {
        // Validate the column exists (optional in production for performance)
        if (app()->isLocal() && !Schema::hasColumn('site_infos', $key)) {
            throw new \Exception("The column '{$key}' does not exist in the site_infos table.");
        }

        // Retrieve value with caching
        return Cache::remember("site_info_{$key}", now()->addHours(24), function () use ($key) {
            $result = SiteInfo::select($key)->first();
            return $result?->{$key} ?? null;
        });
    }


    public function all()
    {
        return Cache::remember('site_infos_all', now()->addHours(24), function () {
            return SiteInfo::all()->pluck('value', 'key')->toArray();
        });
    }
}

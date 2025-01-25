
<?php


use App\Models\Media;
use Illuminate\Support\Facades\DB;

use App\Services\Admin\Manage_site\SiteService;
use App\Services\Admin\Media\MediaService;

function getFirstMedia()
{
    return Media::first();
}


/** Set sidebar active **/

if (!function_exists('setSidebarActive')) {
    function setSidebarActive(array $routes): ?String
    {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'mm-active';
            }
        }
        return null;
    }
}

if (!function_exists('getApiSetting')) {
    function getApiSetting($column)
    {
        return DB::table('couriar_api_settings')->value($column);
    }
}




if (!function_exists('getMedia')) {
    function getMedia($column)
    {
        return app(MediaService::class)->get($column);
    }
}


if (!function_exists('siteInfo')) {
    function siteInfo($key)
    {
        return app(SiteService::class)->get($key);
    }
}




/** check permission */
if (!function_exists('canAccess')) {
    function canAccess(array $permissions): bool
    {
        $permission = auth()->guard('web')->user()->hasAnyPermission($permissions);
        $superAdmin = auth()->guard('web')->user()->hasRole('Super Admin');
        if ($permission || $superAdmin) {
            return true;
        }
        return false;
    }   
}

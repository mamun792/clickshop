<?php

namespace App\Http\Middleware;

use App\Services\Admin\CourierConfigService\CourierConfigService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadCourierSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        CourierConfigService::loadSettings();
        return $next($request);
    }
}

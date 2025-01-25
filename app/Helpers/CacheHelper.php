<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * Remember and cache the result for a specific duration.
     */
    public static function rememberCache(string $cacheKey, \Closure $callback, $minutes = 30)
    {
        return Cache::remember($cacheKey, now()->addMinutes($minutes), $callback);
    }

    /**
     * Invalidate a specific cache key.
     */
    public static function invalidateCache(string $cacheKey)
    {
        Cache::forget($cacheKey);
    }

    /**
     * Generate a cache key dynamically.
     */
    public static function generateCacheKey(string $baseKey, array $params = [])
    {
        return $baseKey . '_' . implode('_', $params);
    }
}



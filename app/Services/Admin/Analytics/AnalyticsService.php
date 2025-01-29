<?php

namespace App\Services\Admin\Analytics;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class AnalyticsService
{
    /**
     * Get total number of users/visitors for the given time period
     */
    public function getTotalVisitors($months)
    {
        $cacheKey = 'total_visitors_' . $months;

        return Cache::remember($cacheKey, 60, function () use ($months) {
            return User::where('created_at', '>=', Carbon::now()->subMonths($months))
                      ->count();
        });
    }

    /**
     * Get unique visitors based on email addresses
     */
    public function getUniqueVisitors($months)
    {
        $cacheKey = 'unique_visitors_' . $months;

        return Cache::remember($cacheKey, 60, function () use ($months) {
            return User::where('created_at', '>=', Carbon::now()->subMonths($months))
                      ->whereNotNull('email')
                      ->distinct('email')
                      ->count();
        });
    }

    /**
     * Calculate average session duration
     */
    public function getAverageSessionDuration($months)
    {
        $cacheKey = 'avg_session_' . $months;

        return Cache::remember($cacheKey, 60, function () use ($months) {
            $now = Carbon::now();

            // Fetch session durations based on last_activity difference
            $avgDuration = DB::table('sessions')
                ->where('last_activity', '>=', $now->subMonths($months)->timestamp)
                ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, FROM_UNIXTIME(last_activity - 1800), FROM_UNIXTIME(last_activity))) as avg_duration')
                ->value('avg_duration');

            if (!$avgDuration || $avgDuration <= 0) {
                return '0m 0s';
            }

            $minutes = floor($avgDuration / 60);
            $seconds = round($avgDuration % 60);

            return "{$minutes}m {$seconds}s";
        });
    }



    /**
     * Get current number of active users
     */
    public function getLiveVisitors()
    {

        $cacheKey = 'live_visitors';

        return Cache::remember($cacheKey, 1, function () {
            return DB::table('sessions')
                ->where('last_activity', '>=', Carbon::now()->subMinutes(5)->timestamp)
                ->count();
        });

    }
    /**
     * Get visitor trends over time
     */
    public function getVisitorTrends($days)
    {
        $cacheKey = 'visitor_trends_' . $days;

        return Cache::remember($cacheKey, 60, function () use ($days) {
            $data = DB::table('sessions')
                ->select([
                    DB::raw('DATE(FROM_UNIXTIME(last_activity)) as date'),
                    DB::raw('COUNT(DISTINCT id) as total'),
                    DB::raw('COUNT(DISTINCT user_id) as unique_visitors')
                ])
                ->where('last_activity', '>=', Carbon::now()->subDays($days)->timestamp)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return [
                'labels' => $data->pluck('date')->map(function($date) {
                    return Carbon::parse($date)->format('M d');
                }),
                'total' => $data->pluck('total'),
                'unique' => $data->pluck('unique_visitors'),
            ];
        });
    }

    /**
     * Get user engagement statistics
     */
    public function getUserEngagement($days)
    {
        $cacheKey = 'user_engagement_' . $days;

        return Cache::remember($cacheKey, 60, function () use ($days) {
            return DB::table('sessions')
                ->select([
                    DB::raw('
                        CASE
                            WHEN TIMESTAMPDIFF(SECOND, FROM_UNIXTIME(last_activity - 1800), FROM_UNIXTIME(last_activity)) < 60 THEN "0-1m"
                            WHEN TIMESTAMPDIFF(SECOND, FROM_UNIXTIME(last_activity - 1800), FROM_UNIXTIME(last_activity)) < 300 THEN "1-5m"
                            WHEN TIMESTAMPDIFF(SECOND, FROM_UNIXTIME(last_activity - 1800), FROM_UNIXTIME(last_activity)) < 600 THEN "5-10m"
                            ELSE "10m+"
                        END as duration_range
                    '),
                    DB::raw('COUNT(*) as count')
                ])
                ->where('last_activity', '>=', Carbon::now()->subDays($days)->timestamp)
                ->groupBy('duration_range')
                ->orderBy(DB::raw('MIN(TIMESTAMPDIFF(SECOND, FROM_UNIXTIME(last_activity - 1800), FROM_UNIXTIME(last_activity)))'))
                ->get();
        });
    }


    /**
     * Get most active pages/routes
     */
    public function getMostActivePages($days = 7, $limit = 5)
    {
        $cacheKey = 'most_active_pages_' . $days . '_' . $limit;

        return Cache::remember($cacheKey, 60, function () use ($days, $limit) {
            return DB::table('sessions')
                ->select([
                    'payload',
                    DB::raw('COUNT(*) as visits')
                ])
                ->where('last_activity', '>=', Carbon::now()->subDays($days)->timestamp)
                ->groupBy('payload')
                ->orderByDesc('visits')
                ->limit($limit)
                ->get()
                ->map(function ($session) {
                    // Extract the last URL from session payload if available
                    $payload = @unserialize(base64_decode($session->payload));
                    $url = $payload['_previous']['url'] ?? 'N/A';
                    return [
                        'url' => $url,
                        'visits' => $session->visits
                    ];
                });
        });
    }
}


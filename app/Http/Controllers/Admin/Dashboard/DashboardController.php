<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Admin\Analytics\AnalyticsService;
use App\Services\Admin\OrderStatistics\OrderStatisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected $analyticsService;
    protected $OrderStatisticsService;

    public function __construct(OrderStatisticsService $OrderStatisticsService, AnalyticsService $analyticsService)
    {
        $this->OrderStatisticsService = $OrderStatisticsService;
        $this->analyticsService = $analyticsService;

    }

    public function index(Request $request)
    {
        $period = $request->get('period', 'today');
        $stats = $this->OrderStatisticsService->getOrderStatistics($period);


        $orderChartData = $this->OrderStatisticsService->orderChartData();



        return view('admin.index', compact('orderChartData', 'stats'));
    }

    public function analytics(Request $request)
    {
        $range = $request->get('range', 1);
        $days = $request->get('days', 7);

        $sessions = DB::table('sessions')
        ->select('ip_address')
        ->whereNotNull('ip_address')
        ->get();

        $distribution = [];
        $countryCounts = [];

        foreach ($sessions as $session) {
            $location = $this->analyticsService->getLocation($session->ip_address);
            $division = $location['division'];
            Log::info($division);
            $country = $location['country'];

            // For detailed distribution
            $distributionKey = "$division ($country)";
            $distribution[$distributionKey] = ($distribution[$distributionKey] ?? 0) + 1;

            // For country-wise counts
            $countryCounts[$country] = ($countryCounts[$country] ?? 0) + 1;
        }



       // return $distribution;
      arsort($distribution);
       arsort($countryCounts);



        $data = [
            'total_visitors' => $this->analyticsService->getTotalVisitors($range),
            'unique_visitors' => $this->analyticsService->getUniqueVisitors($range),
            'avg_session_duration' => $this->analyticsService->getAverageSessionDuration($range),
            'live_visitors' => $this->analyticsService->getLiveVisitors(),
            'visitor_trends' => $this->analyticsService->getVisitorTrends($days),
            'user_engagement' => $this->analyticsService->getUserEngagement($days),

            'country_counts' => $countryCounts,
            'distribution' => $distribution,
        ];

        if ($request->ajax()) {
            return response()->json($data);
        }

        return view('analytics.index', $data);
    }




}

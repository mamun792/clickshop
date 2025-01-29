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

        $data = [
            'total_visitors' => $this->analyticsService->getTotalVisitors($range),
            'unique_visitors' => $this->analyticsService->getUniqueVisitors($range),
            'avg_session_duration' => $this->analyticsService->getAverageSessionDuration($range),
            'live_visitors' => $this->analyticsService->getLiveVisitors(),
            'visitor_trends' => $this->analyticsService->getVisitorTrends($days),
            'user_engagement' => $this->analyticsService->getUserEngagement($days)
        ];

        if ($request->ajax()) {
            return response()->json($data);
        }

        return view('analytics.index', $data);
    }

    public function getMetrics(Request $request)
    {
        $range = $request->get('range', 1);

        return response()->json([
            'total_visitors' => $this->analyticsService->getTotalVisitors($range),
            'unique_visitors' => $this->analyticsService->getUniqueVisitors($range),
            'avg_session_duration' => $this->analyticsService->getAverageSessionDuration($range),
            'live_visitors' => $this->analyticsService->getLiveVisitors(),
        ]);
    }

    public function getChartData(Request $request)
    {
        $days = $request->get('days', 7);

        return response()->json([
            'visitor_trends' => $this->analyticsService->getVisitorTrends($days),
            'user_engagement' => $this->analyticsService->getUserEngagement($days),
        ]);
    }
}

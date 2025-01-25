<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Admin\OrderStatistics\OrderStatisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{

    protected $OrderStatisticsService;

    public function __construct(OrderStatisticsService $OrderStatisticsService)
    {
        $this->OrderStatisticsService = $OrderStatisticsService;

    }

    public function index(Request $request)
    {
        $period = $request->get('period', 'today');
        $stats = $this->OrderStatisticsService->getOrderStatistics($period);


        $orderChartData = $this->OrderStatisticsService->orderChartData();



        return view('admin.index', compact('orderChartData', 'stats'));
    }
}

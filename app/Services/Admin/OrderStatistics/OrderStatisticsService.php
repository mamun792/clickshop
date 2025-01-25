<?php

namespace App\Services\Admin\OrderStatistics;

use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;


class OrderStatisticsService
{
    protected $orderStatuses = [
        'pending',
        'processed',
        'on delivery',
        'pending delivery',
        'delivered',
        'cancelled',
        'returned',
    ];

    public function getOrderStatistics($period = 'all')
    {
        $today = now()->startOfDay();
        [$currentQuery, $previousQuery] = $this->buildQueries($period, $today);

        // Fetch orders in one query
        $currentOrders = $currentQuery->get();
        $previousOrders = $previousQuery->get();

        // Calculate statistics
        $stats = $this->buildStatistics($currentOrders, $previousOrders);

        return $stats;
    }

    protected function buildQueries(string $period, $today): array
    {
        $currentQuery = Order::whereIn('order_status', $this->orderStatuses);
        $previousQuery = Order::whereIn('order_status', $this->orderStatuses);

        // Determine date ranges based on the selected period
        switch ($period) {
            case 'today':
                $currentQuery->whereDate('created_at', $today);
                $previousQuery->whereBetween('created_at', [$today->copy()->subDay(), $today->copy()->subDay()->endOfDay()]);
                break;
            case 'yesterday':
                $currentQuery->whereDate('created_at', $today->copy()->subDay());
                $previousQuery->whereBetween('created_at', [$today->copy()->subDays(2), $today->copy()->subDays(2)->endOfDay()]);
                break;
            case 'tomorrow':
                $currentQuery->whereDate('created_at', $today->copy()->addDay());
                $previousQuery->whereBetween('created_at', [$today, $today->endOfDay()]);
                break;
            case 'last_7_days':
                $currentQuery->whereBetween('created_at', [$today->copy()->subDays(7), $today]);
                $previousQuery->whereBetween('created_at', [$today->copy()->subDays(14), $today->copy()->subDays(7)]);
                break;
            case 'all':
            default:
                // No filters for 'all'
                break;
        }

        return [$currentQuery, $previousQuery];
    }

    protected function buildStatistics(Collection $currentOrders, Collection $previousOrders): array
    {
        $stats = [];

        // Total Orders
        $stats[] = $this->buildStat(
            'Total Orders',
            $currentOrders->count(),
            $previousOrders->count(),
            'bxs-wallet',
            'bg-gradient-burning'
        );

        // Status-wise Orders
        foreach ($this->orderStatuses as $status) {
            $currentCount = $currentOrders->where('order_status', $status)->count();
            $previousCount = $previousOrders->where('order_status', $status)->count();

            $stats[] = $this->buildStat(
                ucfirst($status) . ' Orders',
                $currentCount,
                $previousCount,
                'bxs-group',
                'bg-gradient-ibiza'
            );
        }

        return $stats;
    }

    protected function buildStat(string $title, int $current, int $previous, string $icon, string $iconBg): array
    {
        $trend = $this->calculateTrend($current, $previous);

        return [
            'title' => $title,
            'value' => $current,
            'icon' => $icon,
            'iconBg' => $iconBg,
            'trendClass' => $trend['class'],
            'trendIcon' => $trend['icon'],
            'trendText' => $trend['text'],
        ];
    }

    /**
     * Calculate percentage trend.
     */
    protected function calculateTrend(int $current, int $previous): array
    {
        if ($previous === 0) {
            return [
                'class' => 'text-warning',
                'icon' => 'bx-minus',
                'text' => 'No previous data',
            ];
        }

        $change = (($current - $previous) / $previous) * 100;
        return [
            'class' => $change > 0 ? 'text-success' : 'text-danger',
            'icon' => $change > 0 ? 'bx-trending-up' : 'bx-trending-down',
            'text' => round(abs($change), 2) . '% ' . ($change > 0 ? 'increase' : 'decrease'),
        ];
    }

    public function orderChartData(){
        $orders =
        Order::whereIn('order_status', ['pending', 'delivered', 'processed', 'shipped'])
            ->where('created_at', '>=', Carbon::now()->subDays(15)) 
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d'); 
            });

      
        $orderChartData = collect();

        foreach ($orders as $date => $statusOrders) {
            foreach ($statusOrders->groupBy('order_status') as $status => $statusGroup) {
                $orderChartData->push([
                    'order_date' => $date,
                    'order_status' => ucfirst($status),
                    'total' => $statusGroup->count(),
                ]);
            }
        }

        return $orderChartData;
    }
}
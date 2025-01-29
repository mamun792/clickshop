@extends('admin.master')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row p-4">
            <form action="{{ route('admin.analytics') }}" method="GET" id="date-range-form">
                @csrf

              <div class="col-12 d-flex justify-content-between align-items-center">
                <h1 class="mb-4">Analytics Dashboard</h1>
                <select id="filter-range" class="form-select w-auto" name="range">
                    <option value="1">today</option>
                    <option value="4">Last 7 days</option>
                   
                </select>
               </div>

            </form>

         <!-- Metric Cards -->
<div class="col-12">
    <div class="row" id="metric-cards">
        <!-- Total Visitors -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="metric-card bg-primary bg-opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <div class="metric-value text-light">{{ number_format($total_visitors) }}</div>
                <div class="metric-label text-light">Total Visitors</div>
            </div>
        </div>

        <!-- Unique Visitors -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="metric-card bg-success bg-opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11l2 2 4-4"/>
                </svg>
                <div class="metric-value text-light">{{ number_format($unique_visitors) }}</div>
                <div class="metric-label text-light">Unique Visitors</div>
            </div>
        </div>

        <!-- Avg. Session Duration -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="metric-card bg-info bg-opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24" class="icon">
                    <circle cx="12" cy="12" r="10"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                </svg>
                <div class="metric-value text-light">{{ $avg_session_duration }}</div>
                <div class="metric-label text-light">Avg. Session Duration</div>
            </div>
        </div>

        <!-- Live Visitors -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="metric-card bg-warning bg-opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24" class="icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.5 12h.01M12 12h.01M8.5 12h.01"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 22c4.418 0 8-3.646 8-8.143 0-4.462-2.553-9.67-6.537-11.531a1.73 1.73 0 00-1.926 0C6.553 4.187 4 9.395 4 13.857 4 18.354 7.582 22 12 22z"/>
                </svg>
                <div class="metric-value">
                    <span class="live-indicator"></span>
                    <span id="live-count " class="text-light">{{ $live_visitors }}</span>
                </div>
                <div class="metric-label text-light">Live Visitors</div>
            </div>
        </div>
    </div>
</div>




            <!-- Charts Row -->
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('admin.analytics') }}" method="GET" id="date-range-form">
                            @csrf

                        <div class="chart-container">
                            <div class="chart-header">
                                <span class="chart-title">Visitor Trends</span>
                                <select class="form-select form-select-sm trend-range" style="width: auto;" name="days">
                                    <option value="7">Last 7 days</option>
                                    <option value="30">Last 30 days</option>
                                    <option value="90">Last 90 days</option>
                                </select>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="trendChart"></canvas>
                            </div>
                        </div>
                        </form>
                    </div>

                    <div class="col-lg-6">
                        <div class="chart-container">
                            <div class="chart-header">
                                <span class="chart-title">User Engagement</span>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="engagementChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .metric-card {
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    .metric-card:hover {
        transform: translateY(-5px);
    }
    .metric-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    .metric-value {
        font-size: 1.8rem;
        font-weight: bold;
    }
    .metric-label {
        color: #666;
        font-size: 0.9rem;
    }
    .live-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: #22c55e;
        border-radius: 50%;
        margin-right: 8px;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        min-height: 350px;
        margin-bottom: 1.5rem;
    }
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .chart-title {
        font-size: 1.1rem;
        font-weight: 600;
    }
    .chart-wrapper {
        height: 300px;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let trendChart, engagementChart;
    const initialTrendData = @json($visitor_trends);
    const initialEngagementData = @json($user_engagement);

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: {
                        family: '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto'
                    }
                }
            }
        }
    };

    // Initialize Trend Chart
    function initTrendChart() {
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: initialTrendData.labels,
                datasets: [{
                    label: 'Total Visitors',
                    data: initialTrendData.total,
                    borderColor: '#4F46E5',
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }, {
                    label: 'Unique Visitors',
                    data: initialTrendData.unique,
                    borderColor: '#10B981',
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: commonOptions
        });
    }

    // Initialize Engagement Chart
    function initEngagementChart() {
        const engagementCtx = document.getElementById('engagementChart').getContext('2d');
        engagementChart = new Chart(engagementCtx, {
            type: 'bar',
            data: {
                labels: initialEngagementData.map(item => item.duration_range),
                datasets: [{
                    label: 'Session Duration',
                    data: initialEngagementData.map(item => item.count),
                    backgroundColor: 'rgba(79, 70, 229, 0.7)'
                }]
            },
            options: commonOptions
        });
    }

    // Update Dashboard Data
    async function updateDashboard(range, days) {
        try {
            const response = await fetch(`/analytics?range=${range}&days=${days}`);
            const data = await response.json();

            // Update metrics
            document.querySelector('.metric-value:nth-child(2)').textContent = new Intl.NumberFormat().format(data.total_visitors);
            document.querySelector('.metric-value:nth-child(3)').textContent = new Intl.NumberFormat().format(data.unique_visitors);
            document.querySelector('.metric-value:nth-child(4)').textContent = data.avg_session_duration;
            document.getElementById('live-count').textContent = data.live_visitors;

            // Update charts
            trendChart.data.labels = data.visitor_trends.labels;
            trendChart.data.datasets[0].data = data.visitor_trends.total;
            trendChart.data.datasets[1].data = data.visitor_trends.unique;
            trendChart.update();

            engagementChart.data.labels = data.user_engagement.map(item => item.duration_range);
            engagementChart.data.datasets[0].data = data.user_engagement.map(item => item.count);
            engagementChart.update();
        } catch (error) {
            console.error('Error updating dashboard:', error);
        }
    }

    // Event Listeners
    document.getElementById('filter-range').addEventListener('change', function(e) {
        updateDashboard(e.target.value, document.querySelector('.trend-range').value);
    });

    document.querySelector('.trend-range').addEventListener('change', function(e) {
        updateDashboard(document.getElementById('filter-range').value, e.target.value);
    });

    // Initialize charts
    initTrendChart();
    initEngagementChart();

    // Update live visitors every 30 seconds
    setInterval(() => {
        updateDashboard(
            document.getElementById('filter-range').value,
            document.querySelector('.trend-range').value
        );
    }, 30000);

    // Update dashboard data based on initial filter range
    updateDashboard(document.getElementById('filter-range').value, document.querySelector('.trend-range').value);

    // Update live visitors every 30 seconds
    setInterval(() => {
        updateDashboard(
            document.getElementById('filter-range').value,
            document.querySelector('.trend-range').value
        );
    }, 30000);

    // Update dashboard data based on initial filter range
    updateDashboard(document.getElementById('filter-range').value, document.querySelector('.trend-range').value);

    // date range filter
    $('#filter-range').on('change', function() {
        $('#date-range-form').submit();
    });

});
</script>
@endpush
@endsection

@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <!-- Filter Dropdown -->
        <form method="GET" action="{{ route('dashboard') }}" class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Order Overview</h4>
            <select name="period" class="form-select w-auto" onchange="this.form.submit()">
                <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="yesterday" {{ request('period') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                <option value="tomorrow" {{ request('period') == 'tomorrow' ? 'selected' : '' }}>Tomorrow</option>
                <option value="last_7_days" {{ request('period') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>All Time</option>
            </select>
        </form>
        
        


       
     
        <div id="stats-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
            @include('admin.partials.stats', ['stats' => $stats])
        </div>



        <!---end row--->


        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="mb-0">Performance</h5>

                        </div>
                        <div class="position-relative" id="chart-container">
                            <div class="loading-spinner text-center" id="chart-loading">
                                <!-- Bootstrap spinner -->
                                <div class="spinner-border text-primary" role="status">

                                </div>
                            </div>
                            <div id="chart" style="display: none;">

                            </div>
                            <div id="orderChartData" style="display: none;">
                                {{ json_encode($orderChartData) }}
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
        <!--end row-->








    </div>
@endsection

@push('scripts')
    <script>
     document.addEventListener('DOMContentLoaded', function() {
    const chartLoading = document.querySelector('#chart-loading');
    const chartContainer = document.querySelector('#chart');
    
    if (chartLoading && chartContainer) {
        chartLoading.style.display = 'none';
        chartContainer.style.display = 'block';
    } else {
        console.error("Chart loading or container element not found!");
        return;
    }

    const orderData = @json($orderChartData);
    console.log(orderData);

    let seriesData = [];
    let categories = [];

    orderData.forEach(order => {
        const orderDate = new Date(order.order_date).toISOString();

        if (!categories.includes(orderDate)) {
            categories.push(orderDate);
        }

        let existingSeries = seriesData.find(series => series.name === order.order_status);

        if (existingSeries) {
            existingSeries.data.push(order.total);
        } else {
            seriesData.push({
                name: order.order_status,
                data: [order.total]
            });
        }
    });

    const options = {
        series: seriesData,
        chart: {
            height: 500,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'datetime',
            categories: categories
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };

    const apexChart = new ApexCharts(chartContainer, options);
    apexChart.render();
});

    </script>
   
  
@endpush







{{-- @push('scripts')
   
    <script src="{{ asset('assets/Admin/dashboard/orderChart.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@endpush --}}

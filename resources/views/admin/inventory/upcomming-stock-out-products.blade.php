@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0">Upcoming Stockout</h5>
        </div>
        <div class="card-body">
        <table class="table table-striped table-bordered dataTable w-100" id="dataTable">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Product Code</th>
            <th>Attributes</th>
            <th>Sold</th>
            <th>In Stock</th>
            <th>Initial Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($upcommingStockOutReports as $report)
            <tr>
                <td>{{ $report['product_name'] }}</td>
                <td>{{ $report['product_code'] ?? 'N/A' }}</td>
                <td>
                    @forelse ($report['productCombinations'] as $combination)
                        @php
                            $attributeSummary = collect($combination['attributes'])
                                ->map(fn($attribute) => $attribute['option_name'])
                                ->join('+'); 
                            $initialStock = collect($combination['attributes'])
                                ->sum(fn($attribute) => $attribute['quantity'] + $attribute['sold_quantity']);
                            $soldStock = collect($combination['attributes'])
                                ->sum('sold_quantity');
                            $inStock = collect($combination['attributes'])
                                ->sum('quantity');
                        @endphp
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Attributes:</strong> {{ $attributeSummary ?: 'Single' }} <br>
                                <span class="badge bg-info">Initial Stock:</span> {{ $initialStock }} <br>
                                <span class="badge bg-success">Sold:</span> {{ $soldStock }} <br>
                                <span class="badge bg-warning text-dark">In Stock:</span> {{ $inStock }}
                            </li>
                        </ul>
                    @empty
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Attributes:</strong> N/A <br>
                                <span class="badge bg-info">Initial Stock:</span> {{ $report['quantity'] + $report['sold_quantity'] }} <br>
                                <span class="badge bg-success">Sold:</span> {{ $report['sold_quantity'] }} <br>
                                <span class="badge bg-warning text-dark">In Stock:</span> {{ $report['quantity'] }}
                            </li>
                        </ul>
                    @endforelse
                </td>
                <td>{{ $report['sold_quantity'] }}</td>
                <td style="background: {{ $report['quantity'] > 0 ? ($report['quantity'] <= 10 ? 'rgb(255, 255, 188)' : '') : 'rgb(255, 188, 188)' }};">
                    {{ $report['quantity'] }}
                </td>
                <td>{{ $report['quantity'] + $report['sold_quantity'] }}</td>
                <td>{{ $report['price'] ?? 'N/A' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No stock reports available.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-end">Total</td>
            <td>{{ $upcommingStockOutReports->sum('sold_quantity') }}</td>
            <td>{{ $upcommingStockOutReports->sum('quantity') }}</td>
            <td>{{ $upcommingStockOutReports->sum(fn($report) => $report['quantity'] + $report['sold_quantity']) }}</td>
            <td>{{ $upcommingStockOutReports->sum('price') }}</td>
        </tr>
    </tfoot>
</table>




        </div>
    </div>
    
</div>

@endsection
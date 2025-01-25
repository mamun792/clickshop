@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="card basic-data-table">
            <div class="card-header">
                <h5 class="card-title mb-0">Stockout</h5>
            </div>
            <div class="card-body">
              

                <table class="table table-striped table-bordered dataTable w-100" id="dataTable">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Attribute</th>
                           
                            <th>Sold</th>
                            <th>In Stock</th>
                            <th>Initial Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stockOutReports as $report)
                            <tr>
                                <td>{{ $report['product_name'] }}</td>
                                <td>{{ $report['product_code'] }}</td>
                                <td>
                                    @foreach ($report['product_attributes'] as $attribute)
                                        @if ($loop->first)
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <strong>{{ ucfirst($attribute['attribute']['name']) }}:</strong>
                                                    {{ $attribute['attribute_option']['name'] }} <br>
                                                    <span class="badge bg-info">Initial Stock:</span>
                                                    {{ $attribute['quantity'] + $attribute['sold_quantity'] }} <br>
                                                    <span class="badge bg-success">Sold:</span>
                                                    {{ $attribute['sold_quantity'] }} <br>
                                                    <span class="badge bg-warning text-dark">In Stock:</span>
                                                    {{ $attribute['quantity'] }}
                                                </li>
                                            </ul>
                                        @endif
                                    @endforeach
                    
                                    <button class="btn btn-link text-primary text-decoration-none" data-bs-toggle="collapse"
                                            data-bs-target="#attribute-{{ $loop->index }}">
                                        More Attributes
                                    </button>
                    
                                    <div id="attribute-{{ $loop->index }}" class="collapse">
                                        <ul class="list-group">
                                            @foreach ($report['product_attributes'] as $attribute)
                                                @if (!$loop->first)
                                                    <li class="list-group-item">
                                                        <strong>{{ ucfirst($attribute['attribute']['name']) }}:</strong>
                                                        {{ $attribute['attribute_option']['name'] }} <br>
                                                        <span class="badge bg-info">Initial Stock:</span>
                                                        {{ $attribute['quantity'] + $attribute['sold_quantity'] }} <br>
                                                        <span class="badge bg-success">Sold:</span>
                                                        {{ $attribute['sold_quantity'] }} <br>
                                                        <span class="badge bg-warning text-dark">In Stock:</span>
                                                        {{ $attribute['quantity'] }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ $report['sold_quantity'] }}</td>
                                <td
                                    style="background: {{ $report['quantity'] > 0 ? ($report['quantity'] <= 10 ? 'rgb(255, 255, 188)' : '') : 'rgb(255, 188, 188)' }};">
                                    {{ $report['quantity'] }}
                                </td>
                                <td>{{ $report['quantity'] + $report['sold_quantity'] }}</td>
                                <td>{{ $report['price'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No stock out reports available.</td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- <tfoot>
                        <tr>
                            <td colspan="3" class="text-end">Total</td>
                            <td>{{
                                $stockOutReports->sum(function ($report) {
                                    return $report['sold_quantity'];
                                })
                             }}</td>
                            <td>{{
                                $stockOutReports->sum(function ($report) {
                                    return $report['quantity'];
                                })
                             }}</td>

                            <td>{{
                                $stockOutReports->sum(function ($report) {
                                    return $report['quantity'] + $report['sold_quantity'];
                                })
                             }}</td>
                            <td>{{
                                $stockOutReports->sum(function ($report) {
                                    return $report['price'];
                                })
                             }}</td>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
        </div>
    </div>
@endsection

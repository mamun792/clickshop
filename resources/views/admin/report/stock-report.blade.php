@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <div class="container mt-5">
            <div class="card shadow-sm">
                {{-- Stock REPORT --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Stock Report of Products</h5>
              
                        <a href="#" class="pastel-button pastel-button-green download-csv mx-2" data-table-id="stockReportTable" data-filename="stock_report.csv">
                            Download CSV
                        </a>
                        
                 
                </div>
                <div class="card-body">
                    <table id="stockReportTable" class="table table-striped table-bordered my-table">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Attributes</th>
                                <th>Stock</th>
                                <th>Total Purchase Quantity</th>
                                <th>Average Purchase Price</th>
                                <th>Total Purchase Price</th>
                                <th>Current Stock Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockReports as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($product->productAttributes as $attribute)
                                                <li>
                                                    <strong>{{ ucfirst($attribute->attribute->name) }}:</strong>
                                                    {{ ucfirst($attribute->attributeOption->name) }}
                                                    - <strong>Quantity:</strong> {{ $attribute->quantity }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        @if ($product->quantity > 0)
                                            <i class="fas fa-check-circle text-success" title="Sufficient stock"></i>
                                        @else
                                            <i class="fas fa-times-circle text-danger" title="Out of stock"></i>
                                        @endif
                                        {{ $product->quantity }}
                                    </td>
                                    <td>{{ $product->sold_quantity + $product->quantity }}</td>
                                    <td>
                                        @php
                                            $totalQuantity = $product->sold_quantity + $product->quantity;
                                            $totalPrice = $totalQuantity * $product->price;
                                            $totalQuantity = $totalQuantity > 0 ? $totalQuantity : 1;
                                            $avgPrice = $totalQuantity > 0 ? $totalPrice / $totalQuantity : 0;

                                        @endphp
                                        {{ number_format($avgPrice, 2) }}
                                    </td>
                                    <td>{{ number_format($totalQuantity * $product->price, 2) }}</td>
                                    <th>
                                        {{ number_format($product->quantity * $product->price, 2) }}
                                    </th>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Total</th>
                                <th>{{ $stockReports->sum('quantity') }}</th>
                                <th>{{ $stockReports->sum(function ($product) {
                                    return $product->sold_quantity + $product->quantity;
                                }) }}
                                </th>
                                <th></th>
                                <th>
                                    {{ number_format(
                                        $stockReports->sum(function ($product) {
                                            $totalQuantity = $product->sold_quantity + $product->quantity;
                                            $totalPrice = $totalQuantity * $product->price;
                                            $totalQuantity = $totalQuantity > 0 ? $totalQuantity : 1;
                                            $avgPrice = $totalQuantity > 0 ? $totalPrice / $totalQuantity : 0;
                                            return $totalQuantity * $avgPrice;
                                        }),
                                        2,
                                    ) }}
                                </th>
                                <th>

                                    {{ number_format(
                                        $stockReports->sum(function ($product) {
                                            $avgPrice = $product->average_purchase_price ?: $product->price;
                                            return $product->quantity * $avgPrice;
                                        }),
                                        2,
                                    ) }}


                                </th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    

    
<script src="{{asset('assets/Admin/report/sale.js')}}"> 
</script>

@endpush

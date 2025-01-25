@extends('admin.master')

@section('main-content')
<div class="page-content">






    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0">Stock Management</h5>
        </div>
        <div class="card-body">





        <div class="table-responsive">
        <table class="table table-striped my-table2" id="dataTable">
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
                    @forelse ($stockReports as $report)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                {{-- Featured Image --}}
                                @if (!empty($report['featured_image']))
                                <img
                                    src="{{ asset($report['featured_image']) }}"
                                    alt="{{ $report['product_name'] }}"
                                    class="img-fluid me-2"
                                    style="max-width: 50px; height: auto;">
                                @else
                                <img
                                    src="{{ asset('images/default-placeholder.png') }}"
                                    alt="No image available"
                                    class="img-fluid me-2"
                                    style="max-width: 50px; height: auto;">
                                @endif

                                {{-- Product Name --}}
                                <span>{{ $report['product_name'] }}</span>
                            </div>
                        </td>

                        <td>{{ $report['product_code'] ?? 'N/A' }}</td>
                        <td>
                            @php
                            $combinations = $report['productCombinations'] ?? [];
                            $singleAttributes = collect($combinations)
                            ->filter(fn($combination) => empty($combination['combination_id']))
                            ->first();
                            $combinedAttributes = collect($combinations)
                            ->filter(fn($combination) => !empty($combination['combination_id']));
                            @endphp

                            @if (empty($combinations))
                            <div class="alert alert-info">
                                No attributes found on the product
                            </div>
                            @else
                            {{-- Single Attributes Section --}}
                            @if ($singleAttributes)
                            {{-- Show first attribute by default --}}
                            @foreach ($singleAttributes['attributes'] as $attribute)
                            @if ($loop->first)
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <strong>{{ ucfirst($attribute['attribute_name']) }}:</strong>
                                    {{ $attribute['option_name'] }} <br>
                                    <span class="badge bg-info">Initial Stock:</span>
                                    {{ $attribute['quantity'] + $attribute['sold_quantity'] }} <br>
                                    <span class="badge bg-success">Sold:</span>
                                    {{ $attribute['sold_quantity'] }} <br>
                                    <span class="badge bg-warning">In Stock:</span>
                                    {{ $attribute['quantity'] }}
                                </li>
                            </ul>
                            @endif
                            @endforeach

                            {{-- Show "More Attributes" button only if there are additional attributes --}}
                            @if (count($singleAttributes['attributes']) > 1)
                            <button class="btn btn-link text-primary text-decoration-none" data-bs-toggle="collapse"
                                data-bs-target="#attributes-{{ $report['id'] }}">
                                More Attributes
                            </button>

                            <div id="attributes-{{ $report['id'] }}" class="collapse">
                                <ul class="list-group">
                                    @foreach ($singleAttributes['attributes'] as $attribute)
                                    @if (!$loop->first)
                                    <li class="list-group-item">
                                        <strong>{{ ucfirst($attribute['attribute_name']) }}:</strong>
                                        {{ $attribute['option_name'] }} <br>
                                        <span class="badge bg-info">Initial Stock:</span>
                                        {{ $attribute['quantity'] + $attribute['sold_quantity'] }} <br>
                                        <span class="badge bg-success">Sold:</span>
                                        {{ $attribute['sold_quantity'] }} <br>
                                        <span class="badge bg-warning ">In Stock:</span>
                                        {{ $attribute['quantity'] }}
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @endif

                            {{-- Combined Attributes Section --}}
                            @if ($combinedAttributes->isNotEmpty())
    <div class="mt-3">
        {{-- Show first combination by default --}}
        <ul class="list-group">
            @foreach ($combinedAttributes as $combination)
                @if ($loop->first)
                    @php
                        $attributeSummary = collect($combination['attributes'])
                            ->map(fn($attr) => "{$attr['attribute_name']}: {$attr['option_name']}")
                            ->join(' + ');

                        $attributeCount = collect($combination['attributes'])->count();

                        $initialStock = collect($combination['attributes'])
                            ->sum(fn($attr) => $attr['quantity'] + $attr['sold_quantity']) / $attributeCount;

                        $soldStock = collect($combination['attributes'])
                            ->sum('sold_quantity') / $attributeCount;

                        $inStock = collect($combination['attributes'])
                            ->sum('quantity') / $attributeCount;
                    @endphp
                    <li class="list-group-item">
                        <strong>Combination ID:</strong> {{ $combination['combination_id'] }} <br>
                        <strong>Attributes:</strong> {{ $attributeSummary }} <br>
                        <span class="badge bg-info">Initial Stock:</span> {{ number_format($initialStock) }} <br>
                        <span class="badge bg-success">Sold:</span> {{ number_format($soldStock) }} <br>
                        <span class="badge bg-warning ">In Stock:</span> {{ number_format($inStock) }}
                    </li>
                @endif
            @endforeach
        </ul>

        {{-- Show "More Combinations" button if there are additional combinations --}}
        @if ($combinedAttributes->count() > 1)
            <button class="btn btn-link text-primary text-decoration-none" data-bs-toggle="collapse"
                data-bs-target="#combinations-{{ $report['id'] }}">
                More Combinations
            </button>

            <div id="combinations-{{ $report['id'] }}" class="collapse">
                <ul class="list-group">
                    @foreach ($combinedAttributes as $combination)
                        @if (!$loop->first)
                            @php
                                $attributeSummary = collect($combination['attributes'])
                                    ->map(fn($attr) => "{$attr['attribute_name']}: {$attr['option_name']}")
                                    ->join(' + ');

                                $attributeCount = collect($combination['attributes'])->count();

                                $initialStock = collect($combination['attributes'])
                                    ->sum(fn($attr) => $attr['quantity'] + $attr['sold_quantity']) / $attributeCount;

                                $soldStock = collect($combination['attributes'])
                                    ->sum('sold_quantity') / $attributeCount;

                                $inStock = collect($combination['attributes'])
                                    ->sum('quantity') / $attributeCount;
                            @endphp
                            <li class="list-group-item">
                                <strong>Combination ID:</strong> {{ $combination['combination_id'] }} <br>
                                <strong>Attributes:</strong> {{ $attributeSummary }} <br>
                                <span class="badge bg-info">Initial Stock:</span> {{ number_format($initialStock) }} <br>
                                <span class="badge bg-success">Sold:</span> {{ number_format($soldStock) }} <br>
                                <span class="badge bg-warning ">In Stock:</span> {{ number_format($inStock) }}
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif

                            @endif
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
                        <td>{{ $stockReports->sum('sold_quantity') }}</td>
                        <td>{{ $stockReports->sum('quantity') }}</td>
                        <td>{{ $stockReports->sum(fn ($report) => $report['quantity'] + $report['sold_quantity']) }}</td>
                        <td>{{ $stockReports->sum('price') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>










        </div>
    </div>


</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'csvHtml5',
                    text: 'Download CSV',
                    title: 'Stock Report',
                    className: 'btn btn-success'
                },

            ]
        });
    });
</script>
@endpush
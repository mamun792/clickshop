@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="card">
            <div class="card-header">
                Coupon <a href="{{ route('admin.coupons.create') }}" class="btn btn-sm btn-dark float-end"> Create Coupon </a>
            </div>
            <div class="p-5 bg-white card-body">

                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Discount Amount</th>
                            <th>Valid From</th>
                            <th>Expiry Date</th>
                            <th>Usage Limit</th>
                            <th>With Product</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $key => $coupon)
                            <tr>

                                <td>{{ $key + 1 }}</td>


                                <td>
                                    <span
                                        class="badge py-2 
                                    @if ($coupon->discount_type == 'percentage') bg-success 
                                    @elseif($coupon->discount_type == 'fixed') bg-warning 
                                    @else bg-dark @endif">
                                        {{ ucfirst($coupon->discount_type) }} ({{ $coupon->discount_amount }})
                                    </span>
                                </td>

                                <!-- Validity date -->
                                <td>{{ $coupon->valid_from->format('Y-m-d') }}</td>
                                <td>{{ $coupon->expiry_date->format('Y-m-d') }}</td>

                                <!-- Usage limit -->
                                <td>{{ $coupon->usage_limit }}</td>

                                <!-- Loop through each product associated with the coupon -->
                                <td>
                                    @foreach ($coupon->products as $product)
                                        <ul>
                                            <li>{{ $product->product_name }}</li>
                                        </ul>
                                    @endforeach
                                </td>

                                <!-- Created and updated date -->
                                <td>{{ $coupon->created_at->format('Y-m-d') }}</td>
                                <td>{{ $coupon->updated_at->format('Y-m-d') }}</td>

                                <!-- Action buttons for the coupon -->
                                <td>
                                    <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                        <div class="btn-group-sm" role="group">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                X
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.coupons.add.product', $coupon->id) }}">
                                                        Add / Remove Product
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.coupons.show', $coupon->id) }}">
                                                        Edit Coupon
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach




                    </tbody>
                </table>

            </div>
        </div>


    </div>
@endsection

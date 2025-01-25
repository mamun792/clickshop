@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="card">
            <div class="card-header">
                Coupon Form
            </div>
            <form action="{{ route('admin.coupons.store') }}" method="POST" class="p-4 bg-light card-body">
                @csrf
                <div class="row mb-3">


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">Coupon Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="code" name="code"
                                    value="{{ old('code') }}" placeholder="Enter coupon code">
                                <button type="button" class="btn btn-primary" id="generateCodeBtn">Generate Code</button>
                            </div>
                            @if ($errors->has('code'))
                                <span class="text-danger">{{ $errors->first('code') }}</span>
                            @endif
                        </div>
                    </div>


                    <!-- Discount Amount -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount_amount">Discount Amount</label>
                            <div class="input-group">
                                <select name="discount_type" id="discount_type" class="form-select">
                                    <option value="fixed">Fixed Amount</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                                <input type="text" class="form-control" id="discount_amount" name="discount_amount"
                                    placeholder="Enter discount amount" required>
                                @if ($errors->has('discount_amount'))
                                    <span class="text-danger">{{ $errors->first('discount_amount') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Valid From -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="valid_from">Valid From</label>
                            <input type="date" class="form-control" id="valid_from" name="valid_from" required>
                            @if ($errors->has('valid_from'))
                                <span class="text-danger">{{ $errors->first('valid_from') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Expiry Date -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="expiry_date">Expire Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                            @if ($errors->has('expiry_date'))
                                <span class="text-danger">{{ $errors->first('expiry_date') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Usage Limit -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usage_limit">Coupon Usage Limit</label>
                            <input type="number" min="1" class="form-control" id="usage_limit" name="usage_limit"
                                placeholder="Enter usage limit" required>
                            @if ($errors->has('usage_limit'))
                                <span class="text-danger">{{ $errors->first('usage_limit') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Add Coupon</button>
            </form>
        </div>



        <div class="card">
            <div class="card-header">
                Coupon List
            </div>
            <div class="card-body">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Discount</th>
                            <th>Valid From</th>
                            <th>Expiry Date</th>
                            <th>Usage Limit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->discount_amount }} {{ $coupon->discount_type == 'fixed' ? 'BDT' : '%' }}
                                </td>
                                <td>{{ $coupon->valid_from }}</td>
                                <td>{{ $coupon->expiry_date }}</td>
                                <td>{{ $coupon->usage_limit }}</td>
                                <td>
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                        class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                          </svg></a>
                                  

                                        <button type="button" class="btn btn-danger deleteButton btn-sm"
                                                    data-url="{{ route('admin.coupons.destroy', $coupon->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                    </svg>
                                                </button>


                                                <form id="deleteForm" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="{{ asset('assets/Admin/coupon/uniqueCode.js') }}"></script>
    @endpush

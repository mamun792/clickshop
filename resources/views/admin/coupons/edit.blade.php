@extends('admin.master')

@section('main-content')
    <div class="page-content">



        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5>Edit Coupon</h5>
            </div>
            <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="card-body bg-light p-4">
                @csrf
                @method('PATCH')
        
                <div class="row mb-3">
                    <!-- Discount Type and Amount -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount_type">Discount Type</label>
                            <select name="discount_type" id="discount_type" class="form-select" required>
                                <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="discount_amount">Discount Amount</label>
                            <input type="text" class="form-control" id="discount_amount" name="discount_amount" value="{{ $coupon->discount_amount }}" placeholder="Enter discount amount" required>
                            @if ($errors->has('discount_amount'))
                                <span class="text-danger">{{ $errors->first('discount_amount') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
        
                <div class="row mb-3">
                    <!-- Valid From and Expiry Date -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="valid_from">Valid From</label>
                            <input type="date" class="form-control" id="valid_from" name="valid_from" 
                            value="{{ \Carbon\Carbon::parse($coupon->valid_from ?? now())->format('Y-m-d') }}" required>
                     

                            @if ($errors->has('valid_from'))
                                <span class="text-danger">{{ $errors->first('valid_from') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ \Carbon\Carbon::parse($coupon->expiry_date ?? now())->format('Y-m-d') }}" required>
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
                            <label for="usage_limit">Usage Limit</label>
                            <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="{{ $coupon->usage_limit }}" required>
                            @if ($errors->has('usage_limit'))
                                <span class="text-danger">{{ $errors->first('usage_limit') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
        
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Update Coupon</button>
                </div>
            </form>
        </div>
        


    </div>
@endsection

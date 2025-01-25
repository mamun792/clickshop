@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="card w-50 mx-auto">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="#" class="btn btn-dark">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
            <p class="mb-0 text-center flex-grow-1">Modify: 
                <span class="text-primary">{{ $coupon->code }}</span>
            </p>
           
         

            <button type="button" class="btn btn-danger deleteButton btn-sm"
            data-url="{{ route('admin.coupons.delete.coupon.product', $coupon->id) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                <path
                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
            </svg>
        </button>


        <form id="deleteForm" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
            <input type="hidden" name="product_ids" value="{{ $products->pluck('id')->implode(',') }}">
            @method('DELETE')
        </form>
            
        </div>
    
        <form method="POST" action="{{route('admin.coupons.store.product')}}" class="card-body">
            @csrf
            <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
           
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Product Name</th>
                        <th>Product Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" value="{{ $product->id }}" name="product_ids[]" type="checkbox" role="switch" id="product-{{ $product->id }}" 
                                    @if(in_array($product->id, $coupon->products->pluck('id')->toArray())) checked @endif>
                                   
                            </div>
                            
                            @error('product_ids')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_code }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    
            <div class="card-footer">
                <button type="submit" class="btn btn-success w-100 radius-8 px-14 py-6 text-sm">Add</button>
            </div>
        </form>
    </div>
    
</div>

@endsection
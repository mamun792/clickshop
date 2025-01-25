@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="row gy-4">
        <div class="col-xxl-6 mx-auto">
            <div class="card mb-24">
                <div class="card-header">
                    <h6 class="card-title mb-0">Add Product to This Campaign</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('admin.promotions.store.product.campain')}}">
                        @csrf
                        <div class="row gy-3 mb-3">
                            <div class="col-md-6">
                                <label for="product" class="form-label">Select Product</label>
                                <select class="form-control" id="product" name="product_id">
                                    <option value="">Select a product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                               
                                @error('product_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <div class="col-md-6">
                                <label for="campaign" class="form-label">Select Campaign</label>
                                <select class="form-control" id="campaign" name="campaign_id">
                                    <option value="">Select a campaign</option>
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                                    @endforeach
                                </select>
                                
                                @error('campaign_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="col-md-12 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Attach</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0">Current Campaigns</h5>
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Campaign Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    @foreach($product->campaigns as $campaign)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $campaign->name }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Actions">
                                    <a href="{{ route('admin.promotions.edit.product.campain', $product->id) }}" class="btn btn-primary">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                          </svg>

                                    </a>
                                   

                                    <button type="button" class="btn btn-danger deleteButton btn-sm"
                                    data-url=" {{route('admin.promotions.destroy.product.campain', $product->id) }} ">
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
                                </div>
                            </td>
                        </tr>
                    @endforeach
                       
                @endforeach
                
                </tbody>
            </table>
        </div>
    </div>
    

</div>

@endsection
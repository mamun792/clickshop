@extends('admin.master')

@section('main-content')
<div class="page-content">

    <div class="row">


        <div class="card" id="purchaseFormDiv">
            <div class="container-fluid px-4">
                <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                    {{-- Header --}}
                    <div class="card-header bg-white py-3 px-4 d-flex align-items-center justify-content-between border-bottom">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back
                        </a>
                        <h5 class="mb-0 fw-bold text-primary">Update Purchased Items</h5>
                    </div>

                    {{-- Product Details --}}


                    <div class="card-body p-4">
                        @forelse ($products as $product)
                        <form action="{{ route('admin.purchase.update.purchase') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="product-section mb-4 border rounded p-3 bg-light">
                                {{-- Product Header --}}
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-primary">
                                            {{ $product->product_name }}
                                            <span class="badge bg-primary ms-2">
                                                {{ $product->product_code }}
                                            </span>
                                        </h6>
                                        <small class="text-muted">
                                            Base Price:
                                            <span class="text-success fw-bold">
                                                {{ number_format($product->price, 2) }}
                                            </span>
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-success fs-6">
                                            Total: {{ number_format($product->price, 2) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Hidden Product ID --}}
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                {{-- Attributes Table --}}
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th class="text-center text-primary">Attribute</th>
                                                <th class="text-center text-primary">Option</th>
                                                <th class="text-center text-primary">Quantity</th>
                                                <th class="text-center text-primary">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($product->attributes as $attribute)
                                                <tr>
                                                    <td class="text-center text-secondary">
                                                        {{ $attribute->attribute->name }}
                                                    </td>
                                                    <td class="text-center text-secondary">
                                                        {{ $attribute->option->name }}
                                                    </td>
                                                    <td class="text-center text-secondary">
                                                        {{-- Hidden Attribute ID --}}
                                                        <input type="hidden" name="attribute_ids[]" value="{{ $attribute->id }}">

                                                        {{-- Editable Quantity --}}
                                                        <input type="number" value="{{ $attribute->quantity }}" class="form-control" name="quantities[]" required>
                                                    </td>
                                                    <td class="text-center fw-bold text-success">
                                                        {{-- Editable Price --}}
                                                        <input type="text" value="{{ number_format($attribute->price, 2) }}" class="form-control" name="prices[]" required>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">
                                                        No attributes found for this product
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer bg-white p-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Update {{ $product->product_name }}
                                </button>
                            </div>
                        </form>

                        @empty
                            <div class="alert alert-primary text-center" role="alert">
                                No products purchased
                            </div>
                        @endforelse
                    </div>


                </form>
                </div>
            </div>
        </div>


        {{-- <div class="card" id="purchaseTable">
            <div class="card-header">Purchase Products</div>
            <div class="card-body">
                <form id="purchaseProductsForm">
                    @csrf
                    <input type="hidden" name="purchase_id" id="purchase_id" value="{{$purchase->id}}">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Product Code</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchase->purchase_group as $data)
                            <tr>

                                <td><input type="text" name="name[]" class="form-control" value="{{$data->name}}"
                                        required></td>
                                <td><input type="text" name="product_code[]" class="form-control"
                                        value="{{$data->product_code}}" required></td>
                                <td><input type="number" name="quantity[]" class="form-control quantity"
                                        value="{{$data->quantity}}" required></td>
                                <td><input type="number" step="0.01" name="price[]" class="form-control price"
                                        value="{{$data->price}}" required>
                                </td>
                                <td><input type="number" step="0.01" name="total[]" class="form-control total"
                                        value="{{$data->total}}" readonly>
                                </td>
                                <td>

                                    <button type="button" class="btn btn-primary addRow">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                            <path
                                                d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                            <path
                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                        </svg>

                                    </button>

                                    <button type="button" class="btn btn-danger delete-product"
                                        data-id="{{ $data->id }}">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                        </svg>

                                    </button>


                                </td>
                            </tr>
                            @empty

                            <tr>

                                <td><input type="text" name="name[]" class="form-control"
                                        required></td>
                                <td><input type="text" name="product_code[]" class="form-control"
                                         required></td>
                                <td><input type="number" name="quantity[]" class="form-control quantity"
                                        required></td>
                                <td><input type="number" step="0.01" name="price[]" class="form-control price"
                                        required>
                                </td>
                                <td><input type="number" step="0.01" name="total[]" class="form-control total"
                                       readonly>
                                </td>
                                <td>

                                    <button type="button" class="btn btn-primary addRow">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                            <path
                                                d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                            <path
                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                        </svg>

                                    </button>




                                </td>
                            </tr>


                            @endforelse






                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary btn-sm w-100">Update</button>
                </form>
            </div>
        </div> --}}





    </div>
    @endsection

    @push('scripts')



    @endpush

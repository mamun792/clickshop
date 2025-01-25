@extends('admin.master')

@section('main-content')
    <div class="page-content">



        <div class="container">
            <form id="purchaseForm">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">Create Purchase</h4>
                    </div>
                    <div class="card-body">



                <div class="row mb-4">

                    <div class="col-md-6">
                        <label for="product" class="form-label">Purchase Product Name</label>
                        <input type="text" class="form-control" id="product" name="purchase_name" required
                            value="{{ old('purchase_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" id="purchase_date" required name="purchase_date"
                            value="{{ old('purchase_date') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="invoice_number" class="form-label">Invoice Number</label>
                        <input type="text" class="form-control" id="invoice_number" required
                            name="invoice_number" value="{{ old('invoice_number') }}">
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="document" class="form-label">Document</label>
                            <input type="file" class="form-control" id="document" name="document"
                                accept="image/pdf*">
                        </div>

                    </div>
                    <div class="mb-2">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea class="form-control" id="comment" name="comment"
                            rows="3">{{ old('comment') }}</textarea>
                    </div>

                    <!-- Supplier Selection -->
                    <div class="col-md-6">
                        <label class="form-label">Supplier</label>
                        <select class="form-select select2" name="supplier_id" id="supplier_id">
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Product Selection -->
                    <div class="col-md-6">
                        <label class="form-label">Product</label>
                        <select class="form-select select2" id="productSelect">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-code="{{ $product->product_code }}">
                                    {{ $product->product_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Variant Type Selection -->
                <div class="mb-4">
                    <label class="form-label">Variant Type:</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="singleVariant" name="variantType" value="single" class="form-check-input">
                        <label class="form-check-label" for="singleVariant">Single Variant</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="multipleVariants" name="variantType" value="multiple"
                            class="form-check-input">
                        <label class="form-check-label" for="multipleVariants">Multiple Variants</label>
                    </div>
                </div>





                <div class="row mb-4" id="attributesContainer">
                    @foreach ($attributes ?? [] as $attribute)
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ $attribute['name'] }}</label>
                            <div class="attribute-options">
                                @foreach ($attribute['attribute_options'] as $option)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input attribute-checkbox"
                                            id="attr_{{ $option['id'] }}" value="{{ $option['name'] }}"
                                            data-attribute-id="{{ $option['attribute_id'] }}"
                                            data-name="{{ $attribute['name'] }}">
                                        <label class="form-check-label" for="attr_{{ $option['id'] }}">
                                            {{ $option['name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>




                <button type="button" class="btn btn-primary mb-4" id="addProductButton">Add Product</button>

                <!-- Products Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Variant</th>
                                <th>Quantity</th>
                                <th>Price</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="variantTableBody"></tbody>
                        {{-- <tfoot>
                        <tr>
                            <td colspan="7" class="text-end fw-bold">Grand Total:</td>
                            <td colspan="2" id="grandTotal">৳0.00</td>
                        </tr>
                    </tfoot> --}}
                    </table>
                </div>

                <button type="button" class="btn btn-success mt-3" id="submitSelectedButton">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                        <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1z"/>
                      </svg> Save
                </button>
                    </div>
                </div>
            </form>
        </div>
    @endsection

    @push('scripts')


        <script>
            // Initialize data for JavaScript
            window.purchaseData = {
                attributes: @json($data['attributes'] ?? []),
                attributeOptions: @json($data['attributeOptions'] ?? [])
            };
        </script>
        <script src="{{ asset('assets/Admin/purchase/purchase.js') }}"></script>



        </script>
    @endpush

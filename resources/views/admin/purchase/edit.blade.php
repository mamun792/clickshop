@extends('admin.master')

@section('main-content')
<div class="page-content">

    <div class="row">


        <div class="card" id="purchaseFormDiv">

            <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0"
                style="display: flex; gap: 50px">
                <button class="btn btn-dark btn-sm px-5">Back</button>
                <h5 class="fw-bold-400">Update Purchased</h5>

            </div>

            <div class="card-body">
                <form action="{{ route('admin.purchase.update', $purchase->id) }}" enctype="multipart/form-data"
                    id="purchaseForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="product" class="form-label">Purchase Product Name</label>
                                <input type="text" class="form-control" id="product" name="purchase_name" required
                                    value="{{ old('purchase_name', $purchase->purchase_name) }}">
                            </div>
                            <div class="mb-2">
                                <label for="purchase_date" class="form-label">Purchase Date</label>
                                <input type="date" class="form-control" id="purchase_date" required name="purchase_date"
                                    value="{{ old('purchase_date', $purchase->purchase_date) }}">
                            </div>
                            <div class="mb-2">
                                <label for="invoice_number" class="form-label">Invoice Number</label>
                                <input type="text" class="form-control" id="invoice_number" required
                                    name="invoice_number"
                                    value="{{ old('invoice_number', $purchase->invoice_number) }}">
                            </div>
                            <div class="mb-2">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select class="form-select" id="supplier_id" name="supplier_id">
                                    @foreach($suppliers as $item)
                                    <option value="{{ $item->id }}" {{$item->id == $purchase->supplier_id ? 'selected' :
                                        '' }} >{{ $item->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="mb-2">


                                <label for="document" class="form-label">
                                    Document
                                  

                                    
                                </label>
                                <input type="file" class="form-control" id="document" name="document"
                                    accept="image/pdf*">
                            </div>
                            <div class="mb-2">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea class="form-control" id="comment" name="comment"
                                    rows="3">{{ old('comment', $purchase->comment) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm rounded-30 w-100 mt-2">Update Purchase</button>
                </form>
            </div>
        </div>

        <div class="card" id="purchaseTable">
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
        </div>





    </div>
    @endsection

    @push('scripts')

    <script>
        $(document).ready(function () {
    // Handle the initial purchase form submission
    $('#purchaseForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.purchase.update', $purchase->id) }}",
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response)

                Swal.fire({
                     toast: true,
                     icon: 'success',
                     text: 'Purchase info updated',
                     animation: false,
                     position: 'top-right',
                     showConfirmButton: false,
                     timer: 3000,
                     timerProgressBar: true,
                     didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
              
            }
        });
    });

    // Add a new row to the table for adding products
    $('.addRow').click(function () {
        $('#purchaseTable tbody').append(`
            <tr>
                <td><input type="text" name="name[]" class="form-control" required></td>
                <td><input type="text" name="product_code[]" class="form-control" required></td>
                <td><input type="number" name="quantity[]" class="form-control quantity" required></td>
                <td><input type="number" step="0.01" name="price[]" class="form-control price" required></td>
                <td><input type="number" step="0.01" name="total[]" class="form-control total" readonly></td>
                <td><button type="button" class="btn btn-danger remove-row">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                    </svg>

                     </button>
                </td>
            </tr>
        `);
    });

    // Calculate total based on quantity and price
    $(document).on('input', '.quantity, .price', function () {
        let row = $(this).closest('tr');
        let quantity = parseFloat(row.find('.quantity').val()) || 0;
        let price = parseFloat(row.find('.price').val()) || 0;
        row.find('.total').val((quantity * price).toFixed(2));
    });

    // Remove a product row
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });

    // Handle the submission of the products form
    $('#purchaseProductsForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.purchase.products.update') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                
                Swal.fire({
                     toast: true,
                     icon: 'success',
                     text: 'New data inserted',
                     animation: false,
                     position: 'top-right',
                     showConfirmButton: false,
                     timer: 3000,
                     timerProgressBar: true,
                     didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

              


               // $('#purchaseProductsForm')[0].reset(); // Optionally reset the form
                // Optionally redirect or reload the page
            }
        });
    });
});



    </script>

   
<script>
    $(document).on('click', '.delete-product', function () {
        let productId = $(this).data('id'); // Get the product ID from data-id attribute
        let row = $(this).closest('tr'); // Find the row to remove it after successful deletion

        // Show a confirmation dialog before deleting
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the product.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform the AJAX request to delete the product
                $.ajax({
                    url: "{{ route('admin.purchase.products.delete') }}",  // Fixed the URL syntax here
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token for security
                        product_id: productId  // Include the product ID in the request data
                    },
                    success: function (response) {
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            text: response.message,
                            animation: false,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                        row.remove(); // Remove the row from the table
                    },
                    error: function () {
                        Swal.fire('Error', 'There was an error deleting the product.', 'error');
                    }
                });
            }
        });
    });
</script>




    @endpush
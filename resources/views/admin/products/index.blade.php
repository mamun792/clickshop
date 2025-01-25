@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="row">

            {{-- <div class="col-md-12">
                <div class="card">

                    <div class="card-body">


                        <!-- <form method="GET" action="{{ route('filter.products') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select id="category" class="form-select" name="category_id">
                                        <option value="" selected="">Choose...</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="subcategory" class="form-label">SubCategory</label>
                                    <select id="subcategory" class="form-select" name="subcategory_id">
                                        <option value="" selected="" disabled>Choose...</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" class="form-select" name="status">
                                        <option value="" selected="">Choose...</option>
                                        <option value="Published">Published</option>
                                        <option value="Unpublished">Unpublished</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="product_name" class="form-label">Product Name</label>
                                    <select id="product_name" class="form-select" name="product_name">
                                        <option value="" selected="">Choose...</option>
                                        @foreach ($product as $item)
                                            <option value="{{ $item->product_name }}">{{ $item->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label for="product_code" class="form-label">Product Code</label>
                                    <select id="product_code" class="form-select" name="product_code">
                                        <option value="" selected="">Choose...</option>
                                        @foreach ($product as $item)
                                            <option value="{{ $item->product_code }}">{{ $item->product_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3" style="margin-top: 35px">
                                    <button class="btn btn-primary w-100" type="submit">Filter</button>


                                </div>

                                <div class="col-md-3" style="margin-top: 35px">


                                    <a href="{{ route('products.index') }}" class="btn btn-dark w-100">Refresh</a>
                                </div>


                            </div>
                        </form> -->






                    </div>



                </div>

            </div> --}}


            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="row row-cols-auto g-3 justify-content-end ">

                            <div class="col">
                                <button type="button" class="btn btn-danger px-5 btn-sm radius-30"
                                    id="bulk-delete-btn">Delete</button>
                            </div>


                            <div class="col">
                                <button type="button" class="btn btn-primary px-5 btn-sm radius-30"
                                    id="bulk-unpublish-btn">Unpublish</button>
                            </div>



                            <div class="col">
                                <button type="button" class="btn btn-warning px-5 btn-sm radius-30"
                                    id="bulk-publish-btn">Publish</button>
                            </div>

                        </div>

                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-white" id="example">
                            <thead>
                                <th>
                                    <span style="margin-right: 10px"><input class="form-check-input" type="checkbox"
                                            id="select-all"></span>
                                    SL.
                                </th>
                                <th>product Name</th>
                                <th>Product Code</th>
                                <th>product Category</th>
                                <th>SubCategory</th>
                                <th>Popular</th>
                                <th>Status</th>
                                {{--  free shoping handeler --}}
                                <th>Free Shipping</th>
                                <th>Action</th>
                            </thead>

                            <tbody>

                                @foreach ($product as $index => $item)
                                    <tr>
                                        <td>
                                            <span style="margin-right: 10px"><input class="form-check-input select-item"
                                                    type="checkbox" value="{{ $item->id }}"
                                                    data-id="{{ $item->id }}"></span>
                                            {{ $index + 1 }}
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->featured_image) }}" width="60px" height="60px" />
                                             <span title="{{ $item->product_name }}" style="cursor: pointer">{{ Str::limit($item->product_name, 11, '...') }}</span>

                                        </td>
                                   
                                        <td>{{ Str::limit($item->product_code, 11, '...') }}</td>
                                        <td>{{ $item->category?->name }}</td>
                                        <td>{{ $item->subcategory?->name }}</td>
                                        <td>
                                            <span
                                                class="badge px-3 py-2 fw-200 feature-toggle {{ $item->feature === 'New Arrival' ? 'bg-primary' : 'bg-danger' }}"
                                                data-id="{{ $item->id }}" style="font-weight: 200; cursor: pointer;">
                                                <!-- {{ $item->feature }} -->
                                                @if ( $item->feature === 'New Arrival')
                                                    <span class="badge bg-primary">Popular</span> 
                                                @else
                                                    <span class="badge bg-danger">None</span> 
                                                @endif
                                            </span>


                                        </td>
                                        <td>


                                            <span
                                                class="badge px-3 py-2 fw-200 status-toggle {{ $item->status === 'Published' ? 'bg-primary' : 'bg-danger' }}"
                                                data-id="{{ $item->id }}" style="font-weight: 200; cursor: pointer;">
                                                {{ $item->status }}
                                            </span>



                                        </td>

                                      <td style="text-align: center;">
    <span
        class="badge px-3 py-2 fw-200 {{ $item->is_free_shipping ? 'bg-primary' : 'bg-danger' }} free-shipping-toggle"
        data-id="{{ $item->id }}"
        data-status="{{ $item->is_free_shipping ? 'Yes' : 'No' }}"
        style="font-weight: 200; cursor: pointer; margin:auto;">
        {{ $item->is_free_shipping ? 'Yes' : 'No' }}
    </span>
</td>


                                        <td>
                                            <a href="{{ route('products.edit', $item->id) }}" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>

                                            </a>


                                    

                                            <form action="{{ route('products.destroy', $item->id) }}" method="POST" style="display:inline; margin-left: 10px">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger btn-sm deleteButton">
        <!-- Icon SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash3-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                    </svg>
    </button>
</form>




                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>

                    </div>

                </div>

            </div>


        </div>



    </div>
@endsection

@push('scripts')
    <!----Status script-->

    <script>
        $(document).on('click', '.status-toggle', function() {
            var badge = $(this);
            var productId = badge.data('id');

            $.ajax({
                url: `/admin/products/${productId}/toggle-status`,
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    badge.text(response.status);
                    badge.toggleClass('bg-primary bg-danger'); // Change badge color

                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        text: 'Product status updated',
                        animation: false,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        },
                    });
                },
                error: function() {
                    alert('Failed to update status. Please try again.');
                },
            });
        });
    </script>

    <!---Feature script--->

    <script>
        $(document).on('click', '.feature-toggle', function() {
            var badge = $(this);
            var productId = badge.data('id');

            $.ajax({
                url: `/admin/products/${productId}/toggle-feature`,
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if(response.feature === 'New Arrival'){
                        badge.html('<span class="badge bg-primary">Popular</span>');
                    }else{
                        badge.html('<span class="badge bg-danger">'+response.feature+'</span>');
                    }
                    badge.toggleClass('bg-primary bg-danger'); // Change badge color

                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        text: 'Product featured updated',
                        animation: false,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        },
                    });
                },
                error: function() {
                    alert('Failed to update status. Please try again.');
                },
            });
        });
    </script>


    <!--dynamic dropdown subcategory --->

    <script>
        $(document).ready(function() {
            $('#category').on('change', function() {
                const categoryId = $(this).val();
                const subcategoryDropdown = $('#subcategory');

                // Clear existing options
                subcategoryDropdown.empty().append('<option selected="" disabled>Choose...</option>');

                if (categoryId) {
                    $.ajax({
                        url: `/admin/get-subcategories/${categoryId}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Populate subcategory dropdown
                            console.log(data);
                            $.each(data, function(key, subcategory) {
                                subcategoryDropdown.append(
                                    `<option value="${subcategory.id}">${subcategory.name}</option>`
                                    );
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching subcategories:', error);
                        }
                    });
                }
            });
        });
    </script>

    <!--bulk delete --->
    <script>
        $(document).ready(function() {
            // Select or Deselect all checkboxes
            $('#select-all').on('click', function() {
                let isChecked = $(this).prop('checked');
                $('.select-item').prop('checked', isChecked);
            });

            // Handle Bulk Delete
            $('#bulk-delete-btn').on('click', function() {
                let selectedIds = [];
                $('.select-item:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                console.log(selectedIds);

                if (selectedIds.length > 0) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Perform the AJAX request if the user confirms the deletion
                            $.ajax({
                                url: '/admin/products/bulk-delete', // Change this URL to your route
                                method: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    ids: selectedIds,
                                },
                                success: function(response) {
                                    // Show success alert and reload
                                    Swal.fire(
                                        'Deleted!',
                                        'The product has been deleted.',
                                        'success'
                                    ).then(() => {
                                        location
                                    .reload(); // Reload to update the table
                                    });
                                },
                                error: function() {
                                    // Show error alert
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete the product. Please try again.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                } else {
                    alert('Please select at least one product.');
                }
            });
        });
    </script>

    <!---single alert script-->
<!--
    <script>
        // jQuery to handle the delete action
        $('.deleteButton').on('click', function(e) {
            e.preventDefault(); // Prevent the form from submitting immediately

            // SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if the user confirms the deletion
                    $('#deleteForm').submit();
                }
            });
        });
    </script> -->

    <script>
    $(document).on('click', '.deleteButton', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Get the form associated with the clicked button
        const form = $(this).closest('form');

        // SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the specific form
                form.submit();
            }
        });
    });
</script>


    <!---bulk publish and unpublish--->

    <script>
        $(document).ready(function() {
            // Handle Bulk Publish
            $('#bulk-publish-btn').click(function() {
                // Get selected product IDs
                let selectedIds = [];
                $('.select-item:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });

                // Check if any products are selected
                if (selectedIds.length === 0) {
                    Swal.fire('Warning', 'No products selected. Please select at least one product.',
                        'warning');
                    return;
                }

                // Show confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to publish the selected products?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Publish!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make AJAX request to bulk publish route
                        $.ajax({
                            url: "{{ route('products.bulk.publish') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: selectedIds // Send selected IDs
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Published!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload the page
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred. Please try again.',
                                    'error'
                                );
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

            // Handle Bulk Unpublish
            $('#bulk-unpublish-btn').click(function() {
                // Get selected product IDs
                let selectedIds = [];
                $('.select-item:checked').each(function() {
                    selectedIds.push($(this).data('id'));
                });

                // Check if any products are selected
                if (selectedIds.length === 0) {
                    Swal.fire('Warning', 'No products selected. Please select at least one product.',
                        'warning');
                    return;
                }

                // Show confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to unpublish all products?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Unpublish!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make AJAX request to bulk unpublish route
                        $.ajax({
                            url: "{{ route('products.bulk.unpublish') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: selectedIds // Send selected IDs
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Unpublished!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred. Please try again.',
                                    'error'
                                );
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>



    <script>
      $(document).ready(function() {
    // Toggle free shipping status on click
    $(".free-shipping-toggle").on('click', async function() {
        const productId = $(this).data('id');
        const currentStatus = $(this).data('status');

        // Set newStatus based on currentStatus
        const newStatus = (currentStatus === "Yes") ? 0 : 1; // Toggle the status (0 or 1)

        try {
            // Send AJAX request to update status using Axios with async/await
            const response = await axios.patch(
                `/admin/products/update-free-shipping/${productId}`, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    is_free_shipping: newStatus
                });

            if (response.data.success) {
                // Update the badge text and toggle classes based on new status
                const statusText = newStatus === 1 ? 'Yes' : 'No';
                $(this).text(statusText);
                $(this).data('status', statusText);
                $(this).toggleClass('bg-primary bg-danger');
            } else {
                alert('Failed to update free shipping status.');
            }
        } catch (error) {
            console.error('Error updating free shipping status:', error);
            alert('An error occurred while updating the free shipping status.');
        }
    });
});

    </script>
@endpush

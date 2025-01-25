@extends('admin.master')

@section('main-content')

<div class="page-content">

    <div class="row">
        <!-- Category Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Add New Category</h4>
                {{-- all error --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{route('admin.categories.store')}}" method="post" class="mx-auto"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Category Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter category name">
                        @if($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="image">Category Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if($errors->has('image'))
                        <div class="text-danger">{{ $errors->first('image') }}</div>
                        @endif

                        <!-- Image preview -->
                        <img id="imagePreview" src="#" alt="Image Preview"
                            style="display: none; max-height: 200px; margin-top: 10px; border: 1px solid gainsboro; border-radius: 10px">


                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>

        <!-- Category List -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Category List</h4>
                <p class="card-description">Below is the list of categories.</p>
                <div class="table-responsive">
                    <table id="example" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Img</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Static Category Data Example -->
                            @forelse($categories as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>
                                    @if($item->image)
                                    <img src="{{$item->image}}" alt="Electronics" class="img-fluid"
                                        style="max-width: 80px;">
                                    @else

                                    <img src="https://via.placeholder.com/80" alt="Electronics" class="img-fluid"
                                        style="max-width: 80px;">

                                    @endif



                                </td>

                                <td>
                                    <div class="col">
                                        <div class="dropdown">
                                            <button id="statusButton{{ $item->id }}" class="btn btn-primary dropdown-toggle btn-sm px-3"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $item->status }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="updateStatus({{ $item->id }}, 'Active')">Activate</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="updateStatus({{ $item->id }}, 'Deactive')">Deactivate</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>

                                <td>


                                    <a href="{{ route('admin.categories.edit', $item->id) }}" class="col">
                                        <button type="button"
                                            class="btn btn-primary  btn-sm">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                              </svg>

                                        </button>
                                    </a>





                                    <form action="{{ route('admin.categories.destroy', $item->id) }}" id="deleteForm-{{ $item->id }}"
                                        method="post" style="display:inline; margin-left: 10px">
                                      @method('DELETE')
                                      @csrf
                                      <button type="button" class="btn btn-danger deleteButton btn-sm" data-id="{{ $item->id }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                               class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                              <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5.5 0 0 1 6.5 0h3A1.5.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5.5 0 0 0-.5-.5h-3a.5.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5.5 0 1 0 .998-.06l-.5-8.5a.5.5.5 0 1 0-.998.06m6.53-.528a.5.5.5 0 0 0-.528.47l-.5 8.5a.5.5.5 0 0 0 .998.058l.5-8.5a.5.5.5 0 0 0-.47-.528M8 4.5a.5.5.5 0 0 0-.5.5v8.5a.5.5.5 0 0 0 1 0V5a.5.5.5 0 0 0-.5-.5"/>
                                          </svg>
                                      </button>
                                  </form>




                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No Data Found</td>
                            </tr>
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>




@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        $('#image').change(function (e) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>

<script>
    function updateStatus(categoryId, status) {
        $.ajax({
            url: "{{ route('admin.categories.updateStatus') }}", // You’ll create this route
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                id: categoryId,
                status: status
            },
            success: function(response) {
                if(response.success) {
                    $('#statusButton' + categoryId).text(response.status);
                    // Update the button text with the new status
                    // Reloads the page to reflect changes; or use a more specific update

                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        text: 'Status updated ',
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


                } else {
                    alert("Failed to update status");
                }
            },
            error: function() {
                alert("Error updating status");
            }
        });
    }
</script>




<script>
    $(document).ready(function () {
        // Handle the delete action
        $('.deleteButton').on('click', function (e) {
            e.preventDefault(); // Prevent default action

            // Get the form ID dynamically from the data attribute
            const formId = $(this).data('id');
            const form = $(`#deleteForm-${formId}`); // Reference the form by its unique ID

            if (!form.length) {
                console.error(`Form with ID deleteForm-${formId} not found.`);
                return;
            }

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
    });
</script>




@endpush

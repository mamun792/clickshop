@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="col-lg-12">
            <div class="card container mx-auto">
               
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Manage Blogs</h5>
                        </div>
                        <div class="ms-5">
                            <a href="{{route('blog-category.create')}}"  class="btn btn-primary px-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5"/>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                                  </svg>
                                Add
                            </a>

                            <button type="button" class="btn btn-danger px-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                  </svg>
                                Delete
                            </button>


                        </div>
                    </div>
                </div>
                




            </div>

            <div class="card container mx-auto mt-5">
               
                <div class="card-body">
                    <table class="table table-hover table-stripe" id="example">
                        <thead>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>

                        <tbody>

                            @foreach($blog_categories as $index=>$item)
                            <tr>

                                <td>{{$index+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->slug}}</td>
                                <td>
                                    <button 
                                    class="btn  px-3 btn-sm toggle-status  {{$item->status == 'Enable' ? 'btn-dark' : 'btn-danger'}}  " 
                                    data-id="{{ $item->id }}" 
                                    data-status="{{ $item->status }}">
                                    {{ $item->status }}
                                </button>
                                </td>
                                <td>
    
    
                                    <a href="{{route('blog-category.edit', $item->id)}}" class="col">
                                        <button type="button"
                                            class="btn btn-primary  btn-sm">
    
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                              </svg>
                                        
                                        </button>
                                    </a>
    
    
    
    
    
                                    <form action="{{route('blog-category.destroy', $item->id)}}" id="deleteForm"
                                        method="post" style="display:inline; margin-left: 10px">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-danger deleteButton  btn-sm">
                                            
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
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
@endsection

@push('scripts')

<!----Toggle status script--->
<script>
    $(document).ready(function() {
        // Listen for the toggle-status button click
        $('.toggle-status').on('click', function() {
            let button = $(this);
            let categoryId = button.data('id');
            let currentStatus = button.data('status');

            // Toggle the status
            let newStatus = currentStatus === 'Enable' ? 'Disable' : 'Enable';

            // Send AJAX request
            $.ajax({
                url: "{{ route('blog-category.toggle-status') }}", // Define this route in your Laravel routes
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: categoryId,
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        // Update button text and data-status attribute
                        button.text(newStatus);
                        button.data('status', newStatus);

                        // Update button classes
                        button
                            .removeClass('btn-dark btn-danger') // Remove both classes first
                            .addClass(newStatus === 'Enable' ? 'btn-dark' : 'btn-danger'); // Add the correct class

                        // Show success notification
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            text: 'Category status updated',
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
                        alert('Failed to update status');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });
</script>

<!----delete script--->

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
</script>



@endpush
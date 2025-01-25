@extends('admin.master')

@section('main-content')
    <div class="page-content">
      
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Product List</h6>
                </div>
                <div class="card-body">
    
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Purchase Name</th>
                                <th>Purchase Date</th>
                                <th>Invoice Number</th>
                                <th>Supplier</th>
                                <th>Comment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Static data rows -->
                            @foreach($purchase as $index=>$item)
                            <tr>
                                <td>{{$index+1}}</td>
                                
                            
                                <td>{{$item->purchase_name}}</td> 
                                <td>{{$item->purchase_date}}</td> 
                            
                                <td>
                                    <strong>{{ $item->invoice_number }}</strong> 
                                    <br>
                                    <small class="text-muted"> 
                                        {{ $item->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                
                                <td>{{$item->supplier->supplier_name}}</td>
                                <td>
                                    <span >
                                        {{ $item->comment == 0 ? 'No Comment' : $item->comment }}
                                    </span>
                                    
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Action Buttons">
                                        <a href="{{route('admin.purchase.edit', $item->id)}}" class="btn btn-sm btn-primary" title="Edit">
                                            
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                              </svg>

                                        </a>
                                       

                                        <form action="{{route('admin.purchase.destroy', $item->id)}}" id="deleteForm"
                                            method="post" style="display:inline; margin-left: 10px">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" id="deleteButton"
                                                class="btn btn-danger  btn-sm">
                                                
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                                  </svg>
    
    
                                            </button>
                                        </form>



                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            <!-- Add more static rows as needed -->
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>



        
    </div>

    @endsection

    @push('scripts') 

    <script>
        // jQuery to handle the delete action
        $('#deleteButton').on('click', function(e) {
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

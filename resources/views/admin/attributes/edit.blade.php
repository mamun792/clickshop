@extends('admin.master')

@section('main-content')

<div class="page-content" >
    <div class="col-lg-10 col-md-12 mx-auto grid-margin stretch-card " style="margin-top: 15px">
        <div class="card shadow-sm">
            <div class="card-header ">
               Update Attribute Data
            </div>
            <div class="card-body">
                
                <!-- Form to update attribute name -->
                <div class="mb-5">
                    <h6 class="form-text text-muted"><code>Change Attribute Name:</code></h6>
                    <form action="{{route('admin.attributes.update', $attributes->id)}}" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="name" value="{{$attributes->name}}" required placeholder="Enter attribute name">
                            <button class="btn btn-dark" type="submit">
                                <i class="bi bi-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
    
                <!-- Divider -->
                <hr class="my-4">
    
                <!-- Options list -->

                <!-- Options list -->
<div class="mb-3">
    <p class="form-text text-muted"><code><small>Edit Options:</small></code></p>
    <div class="list-group">

        @if($attributes->attribute_option != null)
            @foreach($attributes->attribute_option as $data)
                <a href="{{ route('admin.attributes.edit.option', $data->id) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    {{ $data->name }}
                    <span class="badge bg-primary px-2 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                          </svg>
                          
                    </span>
                </a>
            @endforeach
        @endif

    </div>
</div>





                
            </div>
        </div>
    </div>
</div>

@endsection
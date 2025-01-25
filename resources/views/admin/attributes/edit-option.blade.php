@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="col-lg-12 col-md-10 col-sm-12 bg-white card shadow-sm">
        <div class="card-header ">
           Update Option Data
        </div>
        <div class="card-body">
            <form action="{{route('admin.attributes.update.option', $attributes_option->id)}}" method="POST">
                @csrf
                @method('PATCH')

               

                <!-- Name Field -->
                <div class="mb-3">
                    <label for="attr_name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" id="attr_name" 
                        value="{{$attributes_option->name}}" required aria-label="Attribute Name">

                    @error('name')

                        <div class="text-danger mt-2">
                            {{ $message }}
                        </div>
                     
                    @enderror
                </div>

             

             
                <!-- Submit Button -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-dark btn-sm px-5" aria-label="Update Option">
                        Update
                    </button>
                    <a href="{{route('admin.attributes.index')}}" class="btn btn-warning px-5 btn-sm "
                        aria-label="Back to Attribute List">
                       Back
                    </a>
                </div>
            </form>
        </div>

        <div class="card-footer text-center">
            <form action="{{route('admin.attributes.destroy.option', $attributes_option->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to delete this option?');" aria-label="Delete Option">
                    <i class="bi bi-trash"></i> Delete This Option
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
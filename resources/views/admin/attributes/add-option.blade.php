@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="row mt-5">
        <div class="col-lg-8 col-md-10 col-sm-12 bg-white p-4 rounded shadow-sm mx-auto my-4">

            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.attributes.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                    <span class="d-none d-sm-inline">Back to Attributes</span>
                </a>
                {{-- <h4 class="mb-0">Add Option</h4> --}}

            </div>
            <div class="text-center mb-4">
                <h6 class="font-weight-bold text-primary">Create New Option  <span class="">({{ $Atibute->name }})</span></h6>
                <p class="text-muted">Fill out the details below to create a new option.</p>
            </div>

            {{-- Display all errors at once --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <form class="admin-form" action="#" method="POST">
                @csrf

                <input type="hidden" name="attribute_id" value="{{$attribute_id}}" />

                <!-- Option Name Field -->
                <div class="row mb-4">
                    <label for="attr_name" class="col-sm-3 col-form-label text-start">Option Name <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" id="attr_name"
                            placeholder="e.g., Color, Size" required>
                        <div class="form-text text-muted">Enter the name of the option.</div>
                    </div>
                </div>



                <!-- Submit Button -->
                <div class="row">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100 hover-shadow">
                            <i class="bi bi-check2-circle"></i> Add Option
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection

@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="mb-4">
        <a href="{{ route('admin.comments.index') }}" class="btn btn-dark btn-sm d-inline-flex align-items-center">
            <i class="fa fa-arrow-left mr-2"></i>  Back to all comments
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Comment</div>
                <div class="card-body">
                    <form action="{{route('admin.comments.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <br>

                        <button type="submit" class="btn btn-primary mt-4">Add Comment</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

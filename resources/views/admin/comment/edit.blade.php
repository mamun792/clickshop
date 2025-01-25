@extends('admin.master')

@section('main-content')

<div class="page-content">

    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    Edit Comment

                    <a href="{{ route('admin.comments.index') }}" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11 3.5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5z"/>
                            <path fill-rule="evenodd" d="M11.354 4.354a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 0 1 .708-.708L8 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-1 0v-11A.5.5 0 0 1 8 1z"/>
                        </svg> Back
                    </a>

                </div>

                <div class="card-body">

                    <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $comment->name }}">

                        </div>

                       
                        <button type="submit" class="btn btn-primary mt-2">Update</button>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
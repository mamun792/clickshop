@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <a href="{{route('admin.account.addPurpose')}}"  class="btn btn-dark">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
              </svg>
        </a>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-light">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <span class="text-center flex-grow-1">Add Purpose</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.account.updatePurpose',$purpose->id) }}" method="POST" id="editPurposeForm">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="purposeName" class="form-label">Purpose Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="purposeName" name="name" placeholder="Enter purpose name" value="{{ old('name', $purpose->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button class="btn btn-primary" type="submit">Update Purpose</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

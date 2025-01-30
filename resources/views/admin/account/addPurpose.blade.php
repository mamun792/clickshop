@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <!-- Back Button -->
        <a href="{{ route('admin.account.accountPurpose') }}" class="btn btn-dark mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-light">
                    <div class="card-header text-center">
                        <h5 class="mb-0">Add Purpose</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.account.storePurpose') }}" method="POST">
                            @csrf

                            <!-- Purpose Name Input -->
                            <div class="mb-3">
                                <label for="purposeName" class="form-label fw-bold">Purpose Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="purposeName" name="name" placeholder="Enter purpose type"
                                       value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i> Add Purpose
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

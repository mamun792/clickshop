@extends('admin.master')

@section('main-content')
    <div class="page-content p-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card shadow-sm border-light">
                    <!-- Card Header with Back Button -->
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.account.accountPurpose') }}" class="btn btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                                </svg>
                                <span class="ms-2 d-none d-sm-inline">Back</span>
                            </a>
                            <h5 class="mb-0 text-center flex-grow-1">Add New Purpose</h5>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <form action="{{ route('admin.account.storePurpose') }}" method="POST">
                            @csrf

                            <!-- Purpose Name Input -->
                            <div class="mb-4">
                                <label for="purposeName" class="form-label fw-medium">Purpose Name</label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="purposeName"
                                       name="name"
                                       placeholder="Enter purpose type"
                                       value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Create Purpose
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

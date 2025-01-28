@extends('admin.master')

@section('main-content')
<div class="page-content">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.account.income') }}" class="btn btn-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                        </svg>
                    </a>
                    <p class="mb-0 text-center flex-grow-1">Add Debit</p>
                </div>

                {{-- Error Handling --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-0">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{route('admin.account.store-debit')}}" method="POST" enctype="multipart/form-data" id="debit-form">
                        @csrf

                        <div class="form-row">
                            <!-- Date -->
                            <div class="col-md-12 mb-3">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="transaction_date" placeholder="Select Date" required>
                                <div class="invalid-feedback">Please select a valid date.</div>
                            </div>

                            <!-- Purpose -->
                            <div class="col-md-12 mb-3">
                                <label for="purpose">Purpose</label>
                                <select class="form-select" id="purpose" name="purpose_id" required>
                                    @foreach($purposes as $purpose)
                                        <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a purpose.</div>
                            </div>

                            <!-- Amount -->
                            <div class="col-md-12 mb-3">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" required>
                                <div class="invalid-feedback">Please enter a valid amount.</div>
                            </div>

                            <!-- Comment -->
                            <div class="col-md-12 mb-3">
                                <label for="comments">Comment</label>
                                <input type="text" class="form-control" id="comment" name="comments" placeholder="Optional Comment">
                            </div>

                            <!-- Debit From -->
                            <div class="col-md-12 mb-3">
                                <label for="account_id">Debit From</label>
                                <select class="form-select" id="account_id" name="account_id" required>
                                    @foreach($accountTypes as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an account.</div>
                            </div>

                            <!-- Hidden Input for Transaction Type -->
                            <input type="hidden" name="transaction_type" value="debit">

                            <!-- Upload Document -->
                            <div class="col-md-12 mb-3">
                                <label for="document">Upload Document</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="document" name="document" aria-describedby="uploadDocument" accept=".pdf,.jpeg,.png"  onchange="previewFile()">
                                    <label class="input-group-text" for="document">
                                        <i class="fas fa-upload"></i> Choose File
                                    </label>
                                </div>
                                <div id="file-preview" class="form-text text-muted mt-2">No file selected</div>
                                <div class="form-text text-muted">Accepted formats: PDF, JPEG, PNG, max size: 5MB</div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-block" id="submit-btn">Add Debit</button>
                                <div id="loading-spinner" class="spinner-border text-primary" role="status" style="display:none;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // File upload preview
    function previewFile() {
        const fileInput = document.getElementById('document');
        const filePreview = document.getElementById('file-preview');
        const file = fileInput.files[0];

        if (file) {
            if (file.type.startsWith('image/')) {
                // Show image preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    filePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 100px;">`;
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                // Show PDF file name
                filePreview.textContent = `PDF File: ${file.name}`;
            } else {
                // For unsupported files
                filePreview.textContent = 'Unsupported file type';
            }
        } else {
            filePreview.textContent = 'No file selected';
        }
    }

    // Enhance Date picker with a library like Flatpickr
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('date');
        if (dateInput) {
            flatpickr(dateInput, {
                altInput: true,
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                defaultDate: new Date(),
                maxDate: 'today',


            });
        }
    });

    // Form validation and submission
    document.getElementById('debit-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const submitButton = document.getElementById('submit-btn');
        const spinner = document.getElementById('loading-spinner');
        submitButton.disabled = true;
        spinner.style.display = 'inline-block';

        // Simulate form submission with a delay
        setTimeout(() => {
            form.submit();
        }, 2000);
    });
</script>
@endpush

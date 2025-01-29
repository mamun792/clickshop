@extends('admin.master')

@section('main-content')
<div class="page-content">
    <!-- Summary Cards Section -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
        <!-- Income Card -->
        <div class="col">
            <div class="card shadow-sm border-start-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-shape bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-cash-coin fs-4 text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Total Income</h6>
                            <h3 class="mb-0 fw-semibold">{{ $income ?? 0 }} ৳</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expense Card -->
        <div class="col">
            <div class="card shadow-sm border-start-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-shape bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-arrow-up-right-circle fs-4 text-danger"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Total Expense</h6>
                            <h3 class="mb-0 fw-semibold">{{ $expense ?? 0 }} ৳</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Balance Card -->
        <div class="col">
            <div class="card shadow-sm h-100 border-start-{{ $balance < 0 ? 'danger' : 'success' }}">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-shape bg-{{ $balance < 0 ? 'danger' : 'success' }} bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-wallet2 fs-4 text-{{ $balance < 0 ? 'danger' : 'success' }}"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Current Balance</h6>
                            <h3 class="mb-0 fw-semibold">
                                {{ $balance }} ৳
                                @if($balance < 0)
                                <i class="bi bi-arrow-down-right fs-5 text-danger"></i>
                                @else
                                <i class="bi bi-arrow-up-right fs-5 text-success"></i>
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Type Card -->
        <div class="col">
            <div class="card shadow-sm border-start-info h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-shape bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-bank2 fs-4 text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-muted">Account Type</h6>
                            <h3 class="mb-0 fw-semibold">{{ $accountType ?? 'N/A' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Section -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Section Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">
                    <i class="bi bi-arrow-left-right me-2"></i>Transaction History
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm" id="addFormButton">
                        <i class="bi bi-plus-circle me-1"></i>Add Debit
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" id="exportButton">
                        <i class="bi bi-download me-1"></i>Export
                    </button>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        <input type="date" class="form-control" id="startDate" placeholder="Start Date">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        <input type="date" class="form-control" id="endDate" placeholder="End Date">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <select class="form-select" id="accountType">
                        @foreach ($accountTypes as $accountType)
                        <option value="{{ $accountType->id }}">{{ $accountType->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Transaction Table -->
            <div class="table-responsive" id="transactionsTable">
                <table class="table table-hover table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Account/Purpose</th>
                            <th class="text-end">Amount</th>
                            <th>Notes</th>
                           <th>Inserted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($debits as $debit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ $debit->created_at->format('d M Y') }}</span>
                                    <small class="text-muted">{{ $debit->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $debit->transaction_type === 'debit' ? 'danger' : 'success' }}">
                                    {{ ucfirst($debit->transaction_type) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ $debit->account->name }}</span>
                                    <small class="text-muted">{{ $debit->purpose->name }}</small>
                                </div>
                            </td>
                            <td class="text-end fw-semibold">{{ number_format($debit->amount, 2) }} ৳</td>
                            <td>{{ $debit->comments ?? 'N/A' }}</td>
                            <td>Admin</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $debits->firstItem() }} to {{ $debits->lastItem() }} of {{ $debits->total() }} entries
                </div>
                <nav>
                    {{ $debits->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-shape {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table-borderless th {
        border-top: none;
    }
    .card-title i {
        font-size: 1.2rem;
        vertical-align: middle;
    }
    .form-select, .form-control {
        border-radius: 0.5rem;
    }
    .btn:hover {
        transition: all 0.3s ease;
    }
    .table-hover tbody tr:hover {
        background-color: #f7f7f7;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add interactive features here
    document.getElementById('addFormButton').addEventListener('click', () => {
        window.location.href = "{{ route('admin.account.add-debit') }}";
    });



    // Date range filter implementation
    flatpickr('#startDate', {
        altInput: true,
        altFormat: 'F j, Y',
        dateFormat: 'Y-m-d',
        maxDate: 'today'
    });

    flatpickr('#endDate', {
        altInput: true,
        altFormat: 'F j, Y',
        dateFormat: 'Y-m-d',
        maxDate: 'today'
    });

    document.getElementById('exportButton').addEventListener('click', function() {
    var table = document.getElementById("transactionsTable");
    var html = table.outerHTML; 
    var url = 'data:application/vnd.ms-excel,' + escape(html);
    var a = document.createElement('a');


    a.href = url;
    a.download = 'transactions.xls';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
});


</script>
@endpush

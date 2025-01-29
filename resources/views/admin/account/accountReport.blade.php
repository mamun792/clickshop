@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Income</h5>
                        <p class="fs-4">{{ number_format($totalCredit, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Expenses</h5>
                        <p class="fs-4">{{ number_format($totalDebit, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white {{ $netTotal < 0 ? 'bg-danger' : 'bg-primary' }} shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Net Balance</h5>
                        <p class="fs-4">{{ number_format($netTotal, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-4">
            <div class="card shadow-lg">
                <div class="card-header ">
                    <h4 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> Account Report</h4>
                </div>



                <div class="card-body">
                    <form id="filterForm" method="GET" action="{{ route('admin.account.account-report') }}" class="mb-4">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" id="startDate" class="form-control" name="startDate">
                            </div>
                            <div class="col-md-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" id="endDate" class="form-control" name="endDate">
                            </div>
                            <div class="col-md-3">
                                <label for="transactionType" class="form-label">Transaction Type</label>
                                <select id="transactionType" class="form-select" name="transaction_type">
                                    <option value="">All Transactions</option>
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                    {{-- <option value="transfer">Transfer</option> --}}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="accountType" class="form-label">Account Category</label>
                                <select id="accountType" class="form-select" name="account_type">
                                    <option value="">All Categories</option>
                                    @foreach ($accountTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="container mt-3">
                        <!-- Summary Cards -->





                        <div class="row">
                            <!-- Transaction Table -->

                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    {{-- <h4 class="fw-bold">Transaction Overview</h4> --}}
                                    <button class="btn btn-outline-success px-4 py-2" id="downloadCSV">
                                        <i class="fas fa-file-csv me-2"></i> Export CSV
                                    </button>
                                </div>
                                <h3 class="fw-bold">Transaction Overview</h3>
                                <table class="table table-hover table-bordered table-striped align-middle">
                                    <thead class="table-dark text-white">
                                        <tr class="text-center">
                                            <th>Date</th>
                                            <th>Transaction ID</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Account</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transactions as $transaction)
                                            <tr class="border-primary shadow-sm">
                                                <td class="px-3">
                                                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M, Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($transaction->transaction_date)->diffForHumans() }}</small>
                                                </td>
                                                <td class="text-center">{{ $transaction->id }}</td>
                                                <td class="text-center">
                                                    <span class="badge {{ $transaction->transaction_type == 'debit' ? 'bg-danger' : 'bg-success' }}">
                                                        {{ $transaction->transaction_type == 'debit' ? 'Expense' : 'Income' }}
                                                    </span>
                                                </td>
                                                <td class="text-end fw-bold {{ $transaction->transaction_type == 'debit' ? 'text-danger' : 'text-success' }}">
                                                    {{ number_format($transaction->amount, 2) }}
                                                </td>
                                                <td class="text-center">{{ $transaction->purpose->name ?? '-' }}</td>
                                                <td class="text-center fw-bold {{ $transaction->account->name == 'BAKSH' ? 'text-warning' : '' }}">
                                                    {{ $transaction->account->name ?? '-' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No transactions found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>


                                </table>
                            </div>



                            <!-- Transfer Table -->
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    {{-- <h4 class="fw-bold">Transaction Overview</h4> --}}
                                    <button class="btn btn-outline-success px-4 py-2" id="downloadlCSV">
                                        <i class="fas fa-file-csv me-2"></i> Export CSV
                                    </button>
                                </div>
                                <h4 class="mb-3">Transfer Data</h4>
                                <table class="table table-hover table-bordered table-striped align-middle">
                                    <thead class="table-dark text-white">
                                        <tr class="text-center">
                                            <th>Date</th>
                                            <th>Transfer ID</th>
                                            <th>Amount</th>
                                            <th>From Account</th>
                                            <th>To Account</th>
                                            <th>
                                                Cost
                                            </th>
                                            <th>
                                                Comments
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transfers as $transfer)
                                            <tr class="border-info shadow-sm">
                                                <td>{{ \Carbon\Carbon::parse($transfer->transfer_date)->format('d M, Y') }}</td>
                                                <td class="text-center">{{ $transfer->id }}</td>
                                                <td class="text-end fw-bold">{{ number_format($transfer->transfer_amount, 2) }}</td>
                                                <td class="text-center">{{ $transfer->from_balance ?? '-' }}</td>
                                                <td class="text-center">{{ $transfer->to_balance ?? '-' }}</td>
                                                <td class="fw-bold">{{ number_format($transfer->cost, 2) }}</td>
                                                <td>{{ $transfer->comments ?? 'N/A' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No transfers found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-lg">
                                    <!-- Previous Page Link -->
                                    @if ($transactions->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $transactions->previousPageUrl() }}" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Page Number Links -->
                                    @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $transactions->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <!-- Next Page Link -->
                                    @if ($transactions->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $transactions->nextPageUrl() }}" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
       $(document).ready(function() {
    $('#downloadCSV').click(function() {
        exportToCSV();
    });

    function exportToCSV() {
        var csv = [];
        var rows = document.querySelectorAll("table tr");

        rows.forEach(row => {
            var rowData = [];
            var cols = row.querySelectorAll("td"); // Exclude headers

            cols.forEach(col => rowData.push(col.innerText.trim())); // Trim spaces
            csv.push(rowData.join(",")); // Convert row to CSV format
        });

        downloadCSV(csv.join("\n"), 'account-report.csv');
    }

    function downloadCSV(csv, filename) {
        var csvFile = new Blob([csv], { type: "text/csv" });
        var downloadLink = document.createElement("a");

        downloadLink.href = URL.createObjectURL(csvFile);
        downloadLink.download = filename;
        downloadLink.click();
    }


    $('#downloadlCSV').click(function() {
        exportToCSV();
    });
});

        </script>
    @endpush

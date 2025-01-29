@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <!-- Summary Cards Section -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white shadow-lg hover-transform">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-wallet fa-3x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Total Income</h5>
                            <h2 class="mb-0">{{ number_format($totalCredit, 2) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-danger text-white shadow-lg hover-transform">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-hand-holding-usd fa-3x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Total Expenses</h5>
                            <h2 class="mb-0">{{ number_format($totalDebit, 2) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card {{ $netTotal < 0 ? 'bg-danger' : 'bg-primary' }} text-white shadow-lg hover-transform">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-balance-scale-right fa-3x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Net Balance</h5>
                            <h2 class="mb-0">{{ number_format($netTotal, 2) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card shadow-lg mb-4 border-0">
            <div class="card-header bg-gradient-primary text-white py-3">
                <h4 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Transactions</h4>
            </div>
            <div class="card-body">
                <form id="filterForm" method="GET" action="{{ route('admin.account.account-report') }}">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <label for="startDate" class="form-label text-primary">
                                <i class="fas fa-calendar-alt me-2"></i>Start Date
                            </label>
                            <input type="date" id="startDate" class="form-control shadow-sm" name="startDate">
                        </div>
                        <div class="col-md-3">
                            <label for="endDate" class="form-label text-primary">
                                <i class="fas fa-calendar-check me-2"></i>End Date
                            </label>
                            <input type="date" id="endDate" class="form-control shadow-sm" name="endDate">
                        </div>
                        <div class="col-md-3">
                            <label for="transactionType" class="form-label text-primary">
                                <i class="fas fa-exchange-alt me-2"></i>Transaction Type
                            </label>
                            <select id="transactionType" class="form-select shadow-sm" name="transaction_type">
                                <option value="">All Transactions</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="accountType" class="form-label text-primary">
                                <i class="fas fa-university me-2"></i>Account Category
                            </label>
                            <select id="accountType" class="form-select shadow-sm" name="account_type">
                                <option value="">All Categories</option>
                                @foreach ($accountTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-4 gradient-btn">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Sections -->
        <div class="row">
            <!-- Transactions Section -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-success text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-list-alt me-2"></i>Transaction Overview</h4>
                            <button class="btn btn-light btn-sm" id="downloadCSV">
                                <i class="fas fa-file-csv me-2"></i>Export CSV
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="bg-light-success">
                                    <tr>
                                        <th class="ps-4">Date</th>
                                        <th>Transaction ID</th>
                                        <th>Type</th>
                                        <th class="text-end">Amount</th>
                                        <th>Description</th>
                                        <th class="pe-4">Account</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $transaction)
                                        <tr class="cursor-pointer">
                                            <td class="ps-4">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-medium">
                                                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M, Y') }}
                                                    </span>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>#{{ $transaction->id }}</td>
                                            <td>
                                                <span class="badge {{ $transaction->transaction_type == 'debit' ? 'bg-danger' : 'bg-success' }} rounded-pill">
                                                    {{ $transaction->transaction_type == 'debit' ? 'Expense' : 'Income' }}
                                                </span>
                                            </td>
                                            <td class="text-end fw-medium {{ $transaction->transaction_type == 'debit' ? 'text-danger' : 'text-success' }}">
                                                {{ number_format($transaction->amount, 2) }}
                                            </td>
                                            <td>{{ $transaction->purpose->name ?? '-' }}</td>
                                            <td class="pe-4">
                                                <span class="d-inline-block {{ $transaction->account->name == 'BAKSH' ? 'text-warning fw-bold' : '' }}">
                                                    {{ $transaction->account->name ?? '-' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                No transactions found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transfers Section -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-purple text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-random me-2"></i>Fund Transfers</h4>
                            <button class="btn btn-light btn-sm" id="downloadTransferCSV">
                                <i class="fas fa-file-csv me-2"></i>Export CSV
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="bg-light-purple">
                                    <tr>
                                        <th class="ps-4">Date</th>
                                        <th>Transfer ID</th>
                                        <th class="text-end">Amount</th>
                                        <th>From Account</th>
                                        <th>To Account</th>
                                        <th class="pe-4">Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transfers as $transfer)
                                        <tr>
                                            <td class="ps-4">
                                                {{ \Carbon\Carbon::parse($transfer->transfer_date)->format('d M, Y') }}
                                            </td>
                                            <td>#{{ $transfer->id }}</td>
                                            <td class="text-end fw-medium text-primary">
                                                {{ number_format($transfer->transfer_amount, 2) }}
                                            </td>
                                            <td>{{ $transfer->from_balance ?? '-' }}</td>
                                            <td>{{ $transfer->to_balance ?? '-' }}</td>
                                            <td class="pe-4 text-danger fw-medium">
                                                {{ number_format($transfer->cost, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                No transfers found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-end mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-separated pagination-lg">
                    @if ($transactions->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $transactions->previousPageUrl() }}">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $transactions->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($transactions->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $transactions->nextPageUrl() }}">
                                <i class="fas fa-chevron-right"></i>
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
@endsection

@push('styles')
    <style>
        .hover-transform {
            transition: transform 0.3s ease;
        }
        .hover-transform:hover {
            transform: translateY(-5px);
        }
        .gradient-btn {
            background-image: linear-gradient(45deg, #4e73df, #224abe);
            border: none;
        }
        .bg-gradient-purple {
            background: linear-gradient(45deg, #6f42c1, #4b2e83);
        }
        .bg-light-purple {
            background-color: #f3e8ff;
        }
        .bg-light-success {
            background-color: #e6ffed;
        }
        .pagination-separated .page-item {
            margin: 0 2px;
        }
        .pagination-separated .page-link {
            border-radius: 8px !important;
        }
    </style>
@endpush

@push('scripts')

    <script>
  // js all data table
    $(document).ready(function() {
      //  csv download js use
        $('#downloadCSV').on('click', function() {
            // get all data js
            var data = [];
            var headers = [];
            var rows = document.querySelectorAll("table tr");
            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");
                for (var j = 0; j < cols.length; j++)
                    row.push(cols[j].innerText);
                data.push(row);
            }
            for (var i = 0; i < document.querySelectorAll("table th").length; i++) {
                headers.push(document.querySelectorAll("table th")[i].innerText);
            }
            //  csv file create js
            var csvFile = '';
            csvFile += headers.join(',') + '\n';
            data.forEach(function(row) {
                csvFile += row.join(',') + '\n';
            });
            var blob = new Blob([csvFile], {
                type: 'text/csv'
            });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', 'transaction.csv');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

        });

        $('#downloadTransferCSV').on('click', function() {
            // get all data js
            var data = [];
            var headers = [];
            var rows = document.querySelectorAll("table tr");
            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");
                for (var j = 0; j < cols.length; j++)
                    row.push(cols[j].innerText);
                data.push(row);
            }
            for (var i = 0; i < document.querySelectorAll("table th").length; i++) {
                headers.push(document.querySelectorAll("table th")[i].innerText);
            }
            //  csv file create js
            var csvFile = '';
            csvFile += headers.join(',') + '\n';
            data.forEach(function(row) {
                csvFile += row.join(',') + '\n';
            });
            var blob = new Blob([csvFile], {
                type: 'text/csv'
            });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', 'transfer.csv');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            
        });

    });



    </script>
@endpush

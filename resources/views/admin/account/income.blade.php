@extends('admin.master')

@section('main-content')
<div class="page-content">
    <div class="row mb-3 ">


        <a href="#" class="col">
            <div class="card shadow-none border bg-gradient-start-2 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center  gap-3">
                        <div
                            class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                            <img src="{{ asset('images/pending.png') }}" class="text-white text-2xl mb-0">
                        </div>
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Total Income</p>
                            <h6 class="mb-0">{{ $income ?? 0 }}</h6>
                        </div>

                        <div id="new-pending-chart" class="remove-tooltip-title rounded-tooltip-value"></div>

                    </div>

                </div>
            </div>
        </a>

        <a href="#" class="col">
            <div class="card shadow-none border bg-gradient-start-3 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                        <div
                            class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                            <img src="{{ asset('images/delivered.png') }}" class="text-white text-2xl mb-0">
                        </div>
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Expense</p>
                            <h6 class="mb-0">{{ $expense ?? 0 }}</h6>
                        </div>

                        <div id="monthly-deleviry-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                    </div>

                </div>
            </div>
        </a>

        {{-- <a href="#" class="col">
            <div class="card shadow-none border bg-gradient-start-2 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                        <div
                            class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                            <img src="{{ asset('images/Returned Order.png') }}" class="text-white text-2xl mb-0">
                        </div>
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Balance</p>
                            <h6 class="mb-0">{{ $balance ?? 0 }}</h6>
                        </div>

                        <div id="total-return-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                    </div>

                </div>
            </div>
        </a> --}}

        @php
            // Calculate income, expense, and balance
            $income = $income ?? 0;
            $expense = $expense ?? 0;
            $balance = $income - $expense;

            // Check if the balance is negative
            $balanceIsNegative = $balance < 0;
        @endphp
        <a href="#" class="col">
            <div class="card shadow-none border {{ $balanceIsNegative ? 'bg-danger' : 'bg-success' }} h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                        <div
                            class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                            <img src="{{ asset('images/Returned Order.png') }}" class="text-white text-2xl mb-0">
                        </div>
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Balance</p>
                            <h6 class="mb-0 {{ $balanceIsNegative ? 'text-white' : 'text-dark' }}">{{ $balance }}</h6>
                        </div>
                        <div id="total-return-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                    </div>
                </div>
            </div>
        </a>

        <a href="#" class="col">
            <div class="card shadow-none border bg-gradient-start-3 h-100">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                        <div
                            class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                            <img src="{{ asset('images/Total Sale.png') }}" class="text-white text-2xl mb-0"></iconify-icon>
                        </div>
                        <div>
                            <p class="fw-medium text-primary-light mb-1">Account Type</p>
                            <h6 class="mb-0">
                                {{ $accountType ?? 0 }}

                            </h6>
                        </div>

                        <div id="total-sal-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                    </div>

                </div>
            </div><!-- card end -->
        </a>

    </div>
    <div class="row mb-3">

        <div class="col-md-12">

            <div class="d-flex justify-content-start mb-3 gap-2">
                <button class="btn btn-dark btn-sm ml-3" id="addFormButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                    </svg>
                </button>


                <a class="nav-link" href="#" id="addActionButton">
                    <div id="creditSection">
                        <!-- Credit Button -->
                        <button class="btn btn-primary btn-sm" id="creditButton">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                class="bi bi-credit-card" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z" />
                                <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                            </svg> Credit
                        </button>
                    </div>


                    <div id="debitSection" style="display: none;">
                        <!-- Debit Button -->
                        <button class="btn btn-primary btn-sm" id="debitButton">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                class="bi bi-credit-card" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z" />
                                <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                            </svg> Debit
                        </button>
                    </div>
                </a>


                <a href="#" id="exportButton" class="btn btn-primary d-flex align-items-center justify-content-center"
                    aria-label="Download" style="width: 40px; height: 40px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-download" viewBox="0 0 16 16">
                        <path
                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                        <path
                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                    </svg>
                </a>

            </div>







                <div class="card mb-12" id="creditTableSection">

                    <p class="text-center">Credit/Income Records</p>

                    <div class="card-body">
                        <form action="#" method="GET">
                            @csrf
                            <div class="form-row d-flex justify-content-between align-items-end flex-wrap gap-2">
                                <div class="col-md-3 mb-3">
                                    <input type="text" class="form-control date-inputn sDate" id="startDate"
                                        placeholder="Start Date" name="startDate" onfocus="(this.type='date')"
                                        onblur="(this.type='text')" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <input type="text" class="form-control date-input nDate" id="endDate"
                                        placeholder="End Date" name="endDate" onfocus="(this.type='date')"
                                        onblur="(this.type='text')" />
                                </div>

                                <input type="hidden" name="transaction_type" value="credit">
                                <div class="col-md-4 mb-3">
                                    <select class="form-select" id="selectOption" name="account_type">

                                        @foreach ($accountTypes as $accountType)
                                            <option value="{{ $accountType->id }}">{{ $accountType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-auto d-flex align-items-center mb-3 gap-2">
                                    <!-- Sync Button -->
                                    <button class="btn btn-dark d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                            <path
                                                d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9" />
                                            <path fill-rule="evenodd"
                                                d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z" />
                                        </svg>
                                    </button>

                                    <!-- Reset Button -->
                                    <a href="{{ route('admin.account.income') }}"
                                        class="btn btn-danger d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                            <path
                                                d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </form>

                        <table class="table table-striped" id="transactionsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Purpose</th>
                                    <th>Credit In</th>
                                    <th>Amount</th>
                                    <th>Comment</th>
                                    <th>Inserted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$credits->isEmpty())
                                    @foreach ($credits as $credit)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span
                                                    class="text-primary">{{ $credit->created_at->format('Y-m-d') }}</span>
                                                <br>
                                                <span
                                                    class="text-success">{{ $credit->created_at->diffForHumans() }}</span>
                                            </td>


                                            <td>{{ $credit->purpose->name }}</td>
                                            <td>{{ $credit->account->name }}
                                                <span class="badge bg-success">
                                                    {{ $credit->transaction_type }}
                                                </span>
                                            </td>
                                            <td>{{ $credit->amount }}</td>
                                            <td>{{ $credit->comments ?? 'N/A' }}</td>
                                            <td>Admin</td>
                                        </tr>
                                    @endforeach
                                @endif

                                @if (!$credits->isEmpty())
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"></td>
                                    <td><strong>= {{ $credits->sum('amount') }}
                                            ৳ </strong></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>


                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between">
                            <div>
                                Showing {{ $credits->firstItem() }} to {{ $credits->lastItem() }} of total
                                {{ $credits->total() }} entries
                            </div>
                            <div>
                                {{ $credits->links() }}
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Debit Section -->
                <div class="card mb-12" id="debitTableSection" style="display: none;">

                    <p class="text-center">Debit/Expense Records</p>

                    <div class="card-body">
                        <form action="#" method="GET">
                            @csrf
                            <div class="form-row d-flex justify-content-between align-items-end flex-wrap gap-2">
                                <div class="col-md-3 mb-3">
                                    <input type="text" class="form-control date-input sDate" id="startDate"
                                        placeholder="Start Date" name="startDate" onfocus="(this.type='date')"
                                        onblur="(this.type='text')" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <input type="text" class="form-control date-input nDate" id="endDate"
                                        placeholder="End Date" name="endDate" onfocus="(this.type='date')"
                                        onblur="(this.type='text')" />
                                </div>

                                <input type="hidden" name="transaction_type" value="debit">

                                <div class="col-md-4 mb-3">
                                    <select class="form-select" id="selectOption" name="account_type">

                                        @foreach ($accountTypes as $accountType)
                                            <option value="{{ $accountType->id }}">{{ $accountType->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-auto d-flex align-items-center mb-3 gap-2">
                                    <!-- Sync Button -->
                                    <button class="btn btn-dark d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                            <path
                                                d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9" />
                                            <path fill-rule="evenodd"
                                                d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z" />
                                        </svg>
                                    </button>

                                    <!-- Reset Button -->
                                    <a href="{{ route('admin.account.income') }}"
                                        class="btn btn-danger d-flex align-items-center justify-content-center"
                                        style="width: 40px; height: 40px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                            <path
                                                d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                        </form>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Purpose</th>
                                    <th>Debit From</th>
                                    <th>Amount</th>
                                    <th>Comment</th>
                                    <th>Inserted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$debits->isEmpty())
                                    @foreach ($debits as $debit)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span
                                                    class="text-primary">{{ $debit->created_at->format('Y-m-d') }}</span>
                                                <br>
                                                <span
                                                    class="text-success">{{ $debit->created_at->diffForHumans() }}</span>
                                            </td>
                                            <td>{{ $debit->purpose->name }}</td>
                                            <td>{{ $debit->account->name }}
                                                <span class="badge bg-danger">
                                                    {{ $debit->transaction_type }}
                                                </span>
                                            </td>
                                            <td>{{ $debit->amount }}</td>
                                            <td>{{ $debit->comments ?? 'N/A' }}</td>
                                            <td>Admin</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                            @if (!$debits->isEmpty())
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"></td>
                                        <td><strong>= {{ $debits->sum('amount') }}
                                                ৳ </strong></td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between">
                            <div>
                                Showing {{ $debits->firstItem() }} to {{ $debits->lastItem() }} of total
                                {{ $debits->total() }} entries
                            </div>
                            <div>
                                {{ $debits->links() }}
                            </div>


                        </div>

                    </div>
                </div>


            


        </div>
    </div>
</div>


@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        let selectedAction = 'credit';

        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById('creditSection').style.display = 'block';
            document.getElementById('debitSection').style.display = 'none';


            document.getElementById('addActionButton').addEventListener('click', function(e) {
                e.preventDefault();


                if (selectedAction === 'credit') {
                    console.log('Toggling to debit');
                    selectedAction = 'debit';
                    document.getElementById('debitSection').style.display = 'block';
                    document.getElementById('creditSection').style.display = 'none';
                    //  table section
                    document.getElementById('creditTableSection').style.display = 'none';
                    document.getElementById('debitTableSection').style.display = 'block';

                } else if (selectedAction === 'debit') {

                    selectedAction = 'credit';
                    document.getElementById('creditSection').style.display = 'block';
                    document.getElementById('debitSection').style.display = 'none';

                    // table section
                    document.getElementById('creditTableSection').style.display = 'block';
                    document.getElementById('debitTableSection').style.display = 'none';
                }
            });


            document.getElementById('addFormButton').addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default behavior


                if (selectedAction === 'credit') {
                    // console.log('Redirecting to credit route');
                    window.location.href = "{{ route('admin.account.add-credit') }}";
                } else if (selectedAction === 'debit') {
                    console.log('Redirecting to debit route');
                    window.location.href = "{{ route('admin.account.add-debit') }}";
                } else {
                    alert('Please select either Credit or Debit before proceeding.');
                }
            });
        });
    </script>

    <script>
        document.getElementById('exportButton').addEventListener('click', function() {

            var table = document.getElementById("transactionsTable");
            var sheet = XLSX.utils.table_to_sheet(table);
            var workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, sheet, "SheetJS");
            XLSX.writeFile(workbook, "transaction-history.xlsx");

        });


        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.querySelector('.sDate');
            const dateInput2 = document.querySelector('.nDate');
            if (dateInput) {
                flatpickr(dateInput, {
                    altInput: true,
                    altFormat: 'F j, Y',
                    dateFormat: 'Y-m-d',
                    defaultDate: new Date(),
                    maxDate: 'today',


                });
            }

            if (dateInput2) {
                flatpickr(dateInput2, {
                    altInput: true,
                    altFormat: 'F j, Y',
                    dateFormat: 'Y-m-d',
                    defaultDate: new Date(),
                    maxDate: 'today',

                });
            }
        });
    </script>
@endpush

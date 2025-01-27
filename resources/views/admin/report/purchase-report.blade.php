@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Purchase Report</h5>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.report.purchase.report') }}" method="GET" class="mb-3">
                    <div class="row g-3">
                        <!-- Start Date -->
                        <div class="col-md-2">
                            <label for="start_date" class="form-label">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ request('start_date') }}" aria-label="Select start date">
                        </div>

                        <!-- End Date -->
                        <div class="col-md-2">
                            <label for="end_date" class="form-label">End Date:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ request('end_date') }}" aria-label="Select end date">
                        </div>

                        <!-- Date Filter -->
                        <div class="col-md-2">
                            <label for="date_filter" class="form-label">Filter by Date:</label>
                            <select class="form-select" id="date_filter" name="date_filter"
                                aria-label="Filter by predefined date ranges">
                                <option value="">Select</option>
                                <option value="today" {{ request('date_filter') === 'today' ? 'selected' : '' }}>Today
                                </option>
                                <option value="yesterday" {{ request('date_filter') === 'yesterday' ? 'selected' : '' }}>
                                    Yesterday</option>
                                <option value="last_7_days"
                                    {{ request('date_filter') === 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>
                                    This Month</option>
                                <option value="last_month" {{ request('date_filter') === 'last_month' ? 'selected' : '' }}>
                                    Last Month</option>
                            </select>
                        </div>

                        <!-- Order Status -->
                        <!-- <div class="col-md-2">
                                    <label for="order_status" class="form-label">Order Status:</label>
                                    <select
                                        class="form-select"
                                        id="order_status"
                                        name="order_status"
                                        aria-label="Filter by order status"
                                    >
                                        <option value="">Select</option>
                                        <option value="pending" {{ request('order_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ request('order_status') === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ request('order_status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ request('order_status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div> -->

                        <!-- Buttons -->
                        <div class="col-md-6 d-flex align-items-center justify-content-end">

                            <button class="pastel-button pastel-button-blue" type="submit"
                                aria-label="Apply filters to order results">
                                <i class="bi bi-filter me-2"></i> Filter
                            </button>
                            <a href="{{ route('admin.report.purchase.report') }}" class="pastel-button pastel-button-rose"
                                aria-label="Reset filters to default">
                                <i class="fas fa-sync-alt me-2"></i> Reset
                            </a>
                            <a href="#" class="pastel-button pastel-button-green download-csv mx-2"
                                data-table-id="purchaseReportTable" data-filename="purchase_report.pdf">Download PDF</a>

                        </div>
                    </div>
                </form>


                <table id="purchaseReportTable" class="table table-striped table-bordered mt-3 my-table">
                    <thead class="table-light">
                        <tr>
                            <th>Supplier</th>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Product Quantity</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $totalQuantity = 0;
                        $totalAmount = 0;
                    @endphp

                    @foreach ($purchaseReports as $purchaseReport)
                        <tr>
                            <td>{{ $purchaseReport->supplier ? $purchaseReport->supplier->supplier_name : 'N/A' }}</td>
                            <td>{{ $purchaseReport->invoice_number }}</td>
                            <td>{{ $purchaseReport->purchase_date }}</td>

                            <!-- Calculate total quantity and amount for each purchase -->
                            <td>
                                @php
                                    $purchaseTotalQuantity = $purchaseReport->products->sum('quantity');
                                    $totalQuantity += $purchaseTotalQuantity;
                                @endphp
                                {{ $purchaseTotalQuantity }}
                            </td>
                            <td>
                                @php
                                    $purchaseTotalAmount = $purchaseReport->products->sum(function($product) {
                                        return $product->price * $product->quantity;
                                    });
                                    $totalAmount += $purchaseTotalAmount;
                                @endphp
                                {{ number_format($purchaseTotalAmount, 2) }}
                            </td>
                        </tr>
                    @endforeach

                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th>{{ $totalQuantity }}</th>
                            <th class="text-end">{{ number_format($totalAmount, 2) }}</th>
                        </tr>
                    </tfoot>

                </table>




                <ul class="pagination">
                    <!-- Previous Page Link -->
                    @if ($purchaseReports->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $purchaseReports->previousPageUrl() }}">Previous</a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @for ($page = 1; $page <= $purchaseReports->lastPage(); $page++)
                        @if ($page == $purchaseReports->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $purchaseReports->url($page) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endfor

                    <!-- Next Page Link -->
                    @if ($purchaseReports->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $purchaseReports->nextPageUrl() }}">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>


            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>


    <script>
        document.querySelector('.download-csv').addEventListener('click', function(e) {
            e.preventDefault();

            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Get the table element
            const tableId = e.target.getAttribute('data-table-id');
            const table = document.getElementById(tableId);

            // Add table to the PDF
            doc.autoTable({
                html: table
            });

            // Get filename
            const filename = e.target.getAttribute('data-filename') || 'table_report.pdf';

            // Save PDF
            doc.save(filename);
        });
    </script>
@endpush

@extends('admin.master')

@section('main-content')

<div class="page-content">
  
        <div class="card">

    
            

            <div class="card-body">
                <form action="{{ route('admin.report.index') }}" method="GET" class="mb-3">
                    <div class="row g-3">
                        <!-- Start Date -->
                        <div class="col-md-2">
                            <label for="start_date" class="form-label">Start Date:</label>
                            <input 
                                type="date" 
                                class="form-control" 
                                id="start_date" 
                                name="start_date" 
                                value="{{ request('start_date') }}" 
                                aria-label="Select start date"
                            >
                        </div>
                
                        <!-- End Date -->
                        <div class="col-md-2">
                            <label for="end_date" class="form-label">End Date:</label>
                            <input 
                                type="date" 
                                class="form-control" 
                                id="end_date" 
                                name="end_date" 
                                value="{{ request('end_date') }}" 
                                aria-label="Select end date"
                            >
                        </div>
                
                        <!-- Date Filter -->
                        <div class="col-md-2">
                            <label for="date_filter" class="form-label">Filter by Date:</label>
                            <select 
                                class="form-select" 
                                id="date_filter" 
                                name="date_filter" 
                                aria-label="Filter by predefined date ranges"
                            >
                                <option value="">Select</option>
                                <option value="today" {{ request('date_filter') === 'today' ? 'selected' : '' }}>Today</option>
                                <option value="yesterday" {{ request('date_filter') === 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                <option value="last_7_days" {{ request('date_filter') === 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>This Month</option>
                                <option value="last_month" {{ request('date_filter') === 'last_month' ? 'selected' : '' }}>Last Month</option>
                            </select>
                        </div>
                
                        <!-- Order Status -->
                        <div class="col-md-2">
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
                        </div>
                
                        <!-- Buttons -->
                        <div class="col-md-4 d-flex align-items-center justify-content-end">
                            <button 
                                class="pastel-button pastel-button-blue" 
                                type="submit" 
                                aria-label="Apply filters to order results"
                            >
                                <i class="bi bi-filter me-2"></i> Filter
                            </button>
                            <button 
                                href="{{ route('admin.report.index') }}" 
                                class="pastel-button pastel-button-rose" 
                                aria-label="Reset filters to default"
                            >
                                <i class="fas fa-sync-alt me-2"></i> Reset
                            </button>
                            
                            <button href="#" 
                               class="pastel-button pastel-button-green download-csv" 
                               data-table-id="orderReportTable" 
                               data-filename="order_report.pdf">
                                Download PDF
                            </button>
                   
            
                        </div>
                    </div>
                </form>
                
                
            
                <table id="orderReportTable" class="table table-striped table-bordered my-table">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Products</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-decoration-none text-dark hover:text-primary">
                                        {{ $order->invoice_number }}
                                    </a>
                                    
                                    
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td>
                                 
                                    {{-- @foreach ($order->items as $item)
                                  
                                        {{ $item->product->product_name }}   <br>
                                        <img src="{{ asset($item->product->featured_image) }}" alt="" width="50px" height="50px">
                                    
                                @endforeach --}}

                                <div class="d-flex flex-column gap-1">
                                    @foreach ($order->items as $item)
                                        <div class="d-flex align-items-center border p-2 rounded">
                                            <img src="{{ asset($item->product->featured_image) }}" 
                                                 alt="{{ $item->product->product_name }}" 
                                                 width="50px" height="50px" 
                                                 class="img-thumbnail me-3"
                                                 loading="lazy">
                                            <div>
                                                <a href="#" class="text-decoration-none fw-bold">
                                                    {{ $item->product->product_name }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                              
                                </td>
                                <td>{{ $order->items->sum('quantity') }}</td>
                                <td> {{ number_format($order->total_price, 2, '.', ',') }}</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th class="text-end"> {{ number_format($orders->sum('total_price'), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
                
               
            
                <ul class="pagination justofy-content-end">
                    <!-- Previous Page Link -->
                    @if ($orders->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $orders->previousPageUrl() }}">Previous</a>
                        </li>
                    @endif
                
                    <!-- Pagination Elements -->
                    @for ($page = 1; $page <= $orders->lastPage(); $page++)
                        @if ($page == $orders->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->url($page) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endfor
                
                    <!-- Next Page Link -->
                    @if ($orders->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $orders->nextPageUrl() }}">Next</a>
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

document.querySelector('.download-csv').addEventListener('click', function (e) {
    e.preventDefault();

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Get the table element
    const tableId = e.target.getAttribute('data-table-id');
    const table = document.getElementById(tableId);

    // Add table to the PDF
    doc.autoTable({ html: table });

    // Get filename
    const filename = e.target.getAttribute('data-filename') || 'table_report.pdf';

    // Save PDF
    doc.save(filename);
});
   
</script>




    
{{-- <script src="{{asset('assets/Admin/report/Stock.js')}}"> 
</script> --}}

@endpush
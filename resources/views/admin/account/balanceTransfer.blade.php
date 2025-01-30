@extends('admin.master')

@section('main-content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Balance Transfers</h5>
                        <a href="{{ route('admin.account.balance-transfer-form') }}" class="btn btn-success btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                              </svg></i> New Transfer
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($transfer->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>From Account</th>
                                    <th>To Account</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-end">Cost</th>
                                    <th>Comment</th>
                                    <th>Created By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transfer as $key => $item)
                                    <tr>
                                        <td>{{ $transfer->firstItem() + $key }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->transfer_date)->format('d M, Y') }}</td>
                                        <td>{{ $item->from_balance }}</td>
                                        <td>{{ $item->to_balance }}</td>
                                        <td class="text-end fw-bold text-success">৳{{ number_format($item->transfer_amount, 2) }}</td>
                                        <td class="text-end text-danger">৳{{ number_format($item->cost, 2) }}</td>
                                        <td>{{ $item->comments ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $item->user->name }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{-- <div class="d-flex justify-content-center mt-3">
                        {{ $transfer->links('vendor.pagination.bootstrap-4') }}
                    </div> --}}

                    @else
                    <div class="alert alert-warning text-center">
                        No balance transfers found.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

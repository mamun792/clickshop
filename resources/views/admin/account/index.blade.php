@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <div class="row row-cols-xxxl-4 row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4 mb-5">
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

            <a href="#" class="col">
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
            </a>

            <a href="#" class="col">
                <div class="card shadow-none border bg-gradient-start-3 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                            <div
                                class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                <img src="{{ asset('images/Total Sale.png') }}"
                                    class="text-white text-2xl mb-0"></iconify-icon>
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
                </div>
            </a>

        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-light">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="text-center flex-grow-1">Add Account</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.account.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="accountName" class="form-label">Account Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="scconutName" name="name" placeholder="Enter Account type"
                                    value="{{ old('name') }}">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>




                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-primary">Add Account</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="card mt-5 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center ">
                <h5 class="mb-0 text-center flex-grow-1">Account Types</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">SL</th>
                            <th scope="col">Account Name</th>
                            <th scope="col" class="text-center">
                                Created At
                            </th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accountTypes as $key => $accountType)
                            <tr>
                                <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                <td>{{ $accountType->name }}</td>
                                <td class="text-center">
                                    <span class="fw-bold text-primary">{{ $accountType->created_at->format('d M, Y') }}</span>
                                    <br>
                                    <small class="text-muted">{{ $accountType->created_at->diffForHumans() }}</small>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('admin.account.edit', $accountType->id) }}"
                                        class="btn btn-sm btn-primary me-2" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                          </svg>
                                    </a>


                                    <form action="{{ route('admin.account.destroy', $accountType->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this account type?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                              </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <div class="card-footer text-end">
                @if ($accountTypes->isNotEmpty())
                    <p class="mb-0">
                        Showing <strong>{{ $accountTypes->firstItem() }}</strong> to
                        <strong>{{ $accountTypes->lastItem() }}</strong> of
                        <strong>{{ $accountTypes->total() }}</strong> entries
                    </p>
                @else
                    <p class="mb-0">No entries found.</p>
                @endif
            </div> --}}
        </div>

        {{-- <div class="mt-4 d-flex justify-content-center">
            {{ $accountTypes->links('pagination::bootstrap-5') }}
        </div> --}}
    </div>
    </div>
        @endsection

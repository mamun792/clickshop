@extends('admin.master')

@section('main-content')
    <div class="page-content">



        <div class="row row-cols-xxxl-4 row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4 mb-5">


            <a href="#" class="col">
                <div class="card shadow-none border bg-gradient-start-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center  gap-3">
                            <div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
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
                            <div class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
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
                            <div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
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
                            <div class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                <img src="{{ asset('images/Total Sale.png') }}" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Account Type</p>
                                <h6 class="mb-0">
                                    {{ $accountType ?? 0}}

                                </h6>
                            </div>

                            <div id="total-sal-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                        </div>

                    </div>
                </div><!-- card end -->
            </a>

        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="{{route('admin.account.addPurpose')}}"  class="btn btn-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0"/>
                                  </svg>
                            </a>
                        </div>
                        <span class="text-center flex-grow-1">Purpose</span>
                    </div>






                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Purpose Name</th>
                                <th scope="col">
                                    Created At
                                </th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purposes as $index => $purpose)
                                <tr>
                                    <th scope="row">
                                        {{ $index + 1  }}
                                    </th>
                                    <td>{{ $purpose->name }}</td>
                                    <td>
                                        <span class="fw-bold text-primary">{{  $purpose->created_at->format('d M, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{  $purpose->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.account.editPurpose', $purpose->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                              </svg>
                                        </a>

                                        <form
                                            action="{{ route('admin.account.destroyPurpose', $purpose->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this purpose?')">
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

                    <div class="mb-3 text-center">
                        {{-- @if ($purposes->isNotEmpty())
                            <p class="mb-0">
                                Showing
                                <strong>{{ $purposes->firstItem() }}</strong> to
                                <strong>{{ $purposes->lastItem() }}</strong> of
                                <strong>{{ $purposes->total() }}</strong> entries
                            </p>
                        @else
                            <p class="mb-0">No entries found.</p>
                        @endif --}}
                    </div>



                    <div class="mt-4">
                                    {{-- {{ $purposes->links('pagination::bootstrap-5') }} --}}
                                </div>



                </div>

            </div>
        </div>
    </div>
@endsection

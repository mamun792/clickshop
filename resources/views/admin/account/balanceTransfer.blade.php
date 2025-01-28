@extends('admin.master')

@section('main-content')
<div class="page-content">
    <div class="row">

        <div class="col-md-12">
            <div class="card mb-10">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('admin.account.balance-transfer-form') }}"  class="btn btn-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                            </a>
                        </div>
                        <div class="col">
                            <h5 class="card-title mb-0">Balance Transfer</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body">


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Cost(%)</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Create By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>Mark</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>Mark</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry the Bird</td>
                                <td>@twitter</td>
                                <td>@mdo</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>Mark</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

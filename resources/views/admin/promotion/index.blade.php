@extends('admin.master')

@section('main-content')

<div class="page-content">
    <div class="card basic-data-table">
        <div class="card-header">
            <div class="card-title mb-0 px-24">
                All Campaigns
                <a href="{{route('admin.promotions.create')}}" class="btn btn-success btn-sm" style="float: right;">
                    <i class="fas fa-plus"></i> Add Campaign
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="datatable" class="my-table table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>Expiry Date</th>
                        <th>Discount</th>
                        <th>Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Static rows example -->
                    @foreach ($campaigns as $campaign)
            <tr>
                <td>{{ $campaign->id }}</td>
                <td>{{ $campaign->name }}</td>
                <td>{{ $campaign->start_date }}</td>
                <td>{{ $campaign->expiry_date }}</td>
                <td>{{ $campaign->discount }}</td>
                <td>{{ $campaign->code }}</td>
                <td>
                    <div class="btn-group gap-3" role="group" aria-label="Actions">
                        <a href="{{route('admin.promotions.edit',$campaign->id )}}" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                              </svg>
                        </a>
                        {{-- <form action="{{route('admin.promotions.destroy',$campaign->id )}}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this campaign?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form> --}}

                        <button type="button" class="btn btn-danger deleteButton btn-sm"
                        data-url=" {{route('admin.promotions.destroy',$campaign->id ) }} ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                        </svg>
                    </button>

                    <form id="deleteForm" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    </div>
                </td>
            </tr>
        @endforeach
                </tbody>
            </table>
        </div>
    </div>
    

</div>

@endsection
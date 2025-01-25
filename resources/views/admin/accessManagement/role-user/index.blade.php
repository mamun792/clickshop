@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Role User</h5>
                <a href="{{ route('role-user.create') }}" class="btn btn-primary">

                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-plus"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                    </svg>
                    Create Role
                </a>

            </div>
            <div class="card-body">
                <table id="example" class="table table-stiped table-hover">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        @forelse ($admins as $admin)
                            <tr>

                                <td>{{ $admin->name }}</td>
                                <td>
                                    {{ $admin->email }}
                                </td>
                                <td>
                                    {{ $admin->getRoleNames()->first() }}
                                </td>

                                <td>
                                    @if ($admin->getRoleNames()->first() !== 'Super Admin')
                                    <a href="{{ route('role-user.edit', $admin->id) }}" class="btn-sm btn btn-primary">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                          </svg>

                                    </a>
                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $admin->id }})" class="btn-sm btn btn-danger delete-item" style="margin-left: 5px">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                          </svg>

                                    </a>

                                    <form id="delete-form-{{ $admin->id }}" action="{{ route('role-user.destroy', $admin->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No result found!</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>


    </div>
@endsection

@push('scripts')

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>

@endpush
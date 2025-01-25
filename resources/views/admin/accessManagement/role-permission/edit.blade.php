@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <form action="{{ route('role-permission.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5>Update Role Permission</h5>
                    <a href="{{ route('role-permission.index') }}" class="btn btn-primary px-5">


                        Back
                    </a>

                </div>

                <div class="card-body">




                    <label class="mb-3 mt-3">Role Name</label>
                    <div class="form-group mb-3">

                        <input type="text" class="form-control" name="name" value="{{ old('name', $role->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>




                </div>


            </div>

            <div class="card">
                <div class="card-body">

                    @foreach ($permissions as $groupname => $permission)
                        <div class="form-group">
                            <h5 class="">{{ $groupname }}</h5>
                            <div class="row mt-3">
                                @foreach ($permission as $item)
                                    <div class="col-md-2">

                                        <div class="form-check form-switch">
                                            <input  {{ in_array($item->name, $rolePermissions) ? 'checked' : '' }} class="form-check-input" name="permissions[]" type="checkbox"
                                                role="switch" id="flexSwitchCheckDefault1" value="{{ $item->name }}">
                                            <label class="form-check-label"
                                                for="flexSwitchCheckDefault1">{{ $item->name }}</label>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                    @endforeach

                </div>
            </div>

            <div class="col mt-3">
                <button type="submit" class="btn btn-primary px-5 w-100">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle mr-1" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"></path>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"></path>
                      </svg>

                    Submit
                </button>
            </div>

        </form>


    </div>
@endsection
@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Role User</h5>
                <a href="{{ route('role-user.index') }}" class="btn btn-primary px-5">Back</a>
            </div>
            <div class="card-body">

                <div class="card mt-5">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Create Role</h5>

                        <form action="{{ route('role-user.create-role') }}" method="POST">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="name" class="form-control" placeholder="Role Name" />
                                <button type="submit" class="btn btn-primary ms-2">Create</button>
                            </div>
                        </form>


                    </div>
                    <div class="card-body">
                        <!-- You can display the list of roles here or additional information -->
                    </div>
                </div>



                <form action="{{ route('role-user.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Name Field -->
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label class="mb-2">Name</label>
                                <input class="form-control" name="name" value="{{ old('name') }}" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label class="mb-2">Email</label>
                                <input class="form-control" name="email" value="{{ old('email') }}" />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label class="mb-2">Password</label>
                                <input class="form-control" name="password" value="{{ old('password') }}" type="password" />
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label class="mb-2">Confirm Password</label>
                                <input class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" type="password" />
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="">Role</label>
                                <select name="role" class="form-select">
                                    <option value="">Select</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-5">Submit</button>

                </form>

            </div>
        </div>

        {{-- Role Create Section --}}


    </div>
@endsection


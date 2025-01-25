@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Role User</h5>
                <a href="{{ route('role-user.index') }}" class="btn btn-primary px-5">

                    Back
                </a>

            </div>
            <div class="card-body">

                <form action="{{ route('role-user.update', $admin->id) }}" method="POST">
                    @csrf

                    @method('PUT')

                    <div class="from-group mt-3">
                        <label class="mb-2">Name</label>
                        <input class="form-control" name="name" value="{{ old('name', $admin->name) }}" />

                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    </div>

                    <div class="from-group mt-3">
                        <label class="mb-2">Email</label>
                        <input class="form-control" name="email" value="{{ old('email', $admin->email) }}" />

                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    </div>

                    <div class="from-group mt-3">
                        <label class="mb-2">password</label>
                        <input class="form-control" name="password"  value="{{ old('password') }}" />

                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    </div>

                    <div class="from-group mt-3">
                        <label class="mb-2">Confirm Password</label>
                        <input class="form-control" name="password_confirmation"  value="{{ old('password_confirmation') }}" />

                        @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    </div>

                    <div class="form-group mt-3">
                        <label for="" class="mb-3">Role</label>
                        <select name="role" id="" class="form-select">
                            <option value="">Select</option>
                            @foreach ($roles as $role)
                                        <option @selected($role->name == $admin->getRoleNames()->first()) value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                        </select>
                        @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-5">Submit</button>


                </form>

            </div>

        </div>


    </div>
@endsection
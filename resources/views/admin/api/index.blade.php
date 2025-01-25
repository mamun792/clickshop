@extends('admin.master')

@section('main-content')
<div class="page-content mt-5">
    <div class="container">
        <div class="row">
            <!-- Form Section -->
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center mb-4">Generate API Token</h2>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="{{ route('generateApiToken') }}">
                            @csrf

                            <div class="d-flex flex-column align-items-center">
                                <p class="fw-bold" style="margin: 0; padding: 0; color: #5e72e4">Select Pathao</p>



                                <div class="form-check form-switch mt-2">
                                    <input
                                    type="checkbox"
                                    class="form-check-input toggle-switch"
                                    name="is_enabled"
                                    value="yes"
                                    style="cursor: pointer"
                                    id="is_enabled"
                                    {{ $patho && $patho->is_enabled === 'yes' ? 'checked' : '' }}
                                    />

                                    {{--  {{ $courierSetting && $courierSetting->pathao === 'yes' ? 'checked' : '' }} --}}

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="client_id" class="form-label">Client ID</label>
                                <input type="text" name="client_id" class="form-control" id="client_id" placeholder="Enter Client ID"  value="{{$patho->client_id ?? ''}}"  required>
                            </div>
                            <div class="mb-3">
                                <label for="client_secret" class="form-label">Client Secret</label>
                                <input type="text" name="client_secret" class="form-control" id="client_secret" placeholder="Enter Client Secret" value="{{$patho->client_secret ?? ''}}" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="email" name="username" class="form-control" id="username" placeholder="Enter Email"  value="{{$patho->username ?? ''}}"  required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" value="{{ $patho->password ?? ''}}"  required>
                            </div>

                            {{-- Store ID --}}
                            <div class="mb-3">
                                <label for="store_id" class="form-label">Store ID</label>
                                <input type="text" name="StoreId" class="form-control" id="store_id" placeholder="Enter Store ID" value="{{$patho->StoreId ?? ''}}"  required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Generate Token</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection

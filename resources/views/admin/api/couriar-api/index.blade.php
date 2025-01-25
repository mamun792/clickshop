@extends('admin.master')

@section('main-content')
<div class="page-content">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="row g-4 mt-5">

        <div class="col-md-12 row">
            <div class="col-md-6">
            <form action="{{ route('couriarApi.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-6">
                    <div class="card">

                        <div class="card-body">


                            <div class="d-flex justify-content-center">
                                <img class="img-fluid " style="height: 250px" src="{{asset('uploads/Steadfast.png')}}" />
                            </div>



                            <div class="d-flex flex-column align-items-center">
                                <p class="fw-bold" style="margin: 0; padding: 0; color: #5e72e4">Select Steadfast</p>

                                <input type="hidden" name="steadfast" value="no">

                                <div class="form-check form-switch mt-2">
                                    <!-- Set the checked attribute based on the value of is_active -->
                                    <input
                                    type="checkbox"
                                    class="form-check-input toggle-switch"
                                    name="steadfast"
                                    value="yes"
                                    style="cursor: pointer"
                                    {{ $courierSetting && $courierSetting->steadfast === 'yes' ? 'checked' : '' }}
                                />


                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="input1" class="form-label">Courier API Key</label>
                                <input type="text" name="api_key" class="form-control" id="input1" placeholder="API Key"
                                    value="{{ $courierSetting ? $courierSetting->api_key : old('api_key') }}">
                                @error('api_key')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="input2" class="form-label">Courier Secret Key</label>
                                <input type="text" name="secret_key" class="form-control" id="input2"
                                    placeholder="Secret Key"
                                    value="{{ $courierSetting ? $courierSetting->secret_key : old('secret_key') }}">
                                @error('secret_key')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <button class="btn btn-primary w-100 mt-3 mb-5">Submit</button>

                        </div>





                    </div>


                </div>

                {{-- <div class="col-md-3">
                    <div class="card">

                        <div class="card-body">


                            <div class="d-flex justify-content-center">
                                <img class="img-fluid " style="height: 100px" src="{{asset('uploads/Pathao.png')}}" />
                            </div>



                            <div class="d-flex flex-column align-items-center">
                                <p class="fw-bold" style="margin: 0; padding: 0; color: #5e72e4">Select Pathao</p>

                                <input type="hidden" name="pathao" value="no">

                                <div class="form-check form-switch mt-2">
                                    <input
                                    type="checkbox"
                                    class="form-check-input toggle-switch"
                                    name="pathao"
                                    value="yes"
                                    style="cursor: pointer"
                                    {{ $courierSetting && $courierSetting->pathao === 'yes' ? 'checked' : '' }}
                                    />

                                </div>
                            </div>



                            <div class="col-md-12">
                                <label for="pathao_client_id" class="form-label">Pathao Client ID</label>
                                <input type="text" class="form-control" name="pathao_client_id" id="pathao_client_id"
                                    value="{{ $courierSetting ? $courierSetting->pathao_client_id : old('pathao_client_id') }}"
                                    placeholder="Pathao Client Id">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="pathao_client_secret" class="form-label">Pathao Client Secret</label>
                                <input type="text" class="form-control" name="pathao_client_secret"
                                    id="pathao_client_secret"
                                    value="{{ $courierSetting ? $courierSetting->pathao_client_secret : old('pathao_client_secret') }}"
                                    placeholder="Pathao Client Secret">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="pathao_client_secret" class="form-label">Pathao Secret Token</label>
                                <input type="text" class="form-control" name="pathao_secret_token"
                                    id="pathao_secret_token"
                                    value="{{ $courierSetting ? $courierSetting->pathao_secret_token : old('pathao_secret_token') }}"
                                    placeholder="Pathao Secret Token">
                            </div>


                            <div class="col-md-12 mt-2">
                                <label for="pathao_store_id" class="form-label">Store ID</label>
                                <input type="text" class="form-control" name="pathao_store_id"
                                    id="pathao_store_id"
                                    value="{{ $courierSetting ? $courierSetting->pathao_store_id : old('pathao_store_id') }}"
                                    placeholder="Pathao Store ID">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="pathao_store_name" class="form-label">Store Name</label>
                                <input type="text" class="form-control" name="pathao_store_name"
                                    id="pathao_store_name"
                                    value="{{ $courierSetting ? $courierSetting->pathao_store_name : old('pathao_store_name') }}"
                                    placeholder="Pathao Store Name">
                            </div>



                            <button type="submit" class="btn btn-primary w-100 mt-3 mb-5">Submit</button>

                        </div>




                    </div>


                </div> --}}

                <div class="col-md-6">
                    <div class="card">

                        <div class="card-body">


                            <div class="d-flex justify-content-center">
                                <img class="img-fluid " style="height: 250px" src="{{asset('uploads/Redx.png')}}" />
                            </div>



                            <div class="d-flex flex-column align-items-center">
                                <p class="fw-bold" style="margin: 0; padding: 0; color: #5e72e4">Select Redx</p>

                                <input type="hidden" name="redx" value="no">

                                <div class="form-check form-switch mt-2">
                                    <input
                                    type="checkbox"
                                    class="form-check-input toggle-switch"
                                    name="redx"
                                    value="yes"
                                    style="cursor: pointer"
                                    {{ $courierSetting && $courierSetting->redx === 'yes' ? 'checked' : '' }}

                                    />

                                </div>
                            </div>



                            <div class="col-md-12">
                                <label for="input1" for="redx_sandbox" class="form-label">RedX Sandbox Url</label>
                                <input type="text" class="form-control" id="redx_sandbox" name="redx_sandbox"
                                    value="{{ $courierSetting ? $courierSetting->redx_sandbox : old('redx_sandbox') }}"
                                    placeholder="RedX Sandbox Mode" disabled>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="redx_access_token" class="form-label">RedX Access Token</label>
                                <input type="text" class="form-control" id="redx_access_token" name="redx_access_token"
                                    value="{{ $courierSetting ? $courierSetting->redx_access_token : old('redx_access_token') }}"
                                    placeholder="RedX Access Token">
                            </div>


                            <button class="btn btn-primary w-100 mt-3 mb-5">Submit</button>

                        </div>


                    </div>


                </div>


            </div>


        </form>
            </div>
            <div class="col-md-5">
            <div class="row">
            <!-- Form Section -->
            <div class="col-md-12">
                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="{{ route('generateApiToken') }}">
                            @csrf

                            <div class="d-flex justify-content-center align-center" style="height: 200px;align-items: center;" >
                                <img class="img-fluid" style="height: 200px;align-items: center;"  src="{{asset('uploads/Pathao.png')}}" />
                            </div>

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
                            <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_id" class="form-label">Client ID</label>
                                    <input type="text" name="client_id" class="form-control" id="client_id" placeholder="Enter Client ID"  value="{{$patho->client_id ?? ''}}"  required>
                                </div>
                                <div class="mb-3">
                                    <label for="client_secret" class="form-label">Client Secret</label>
                                    <input type="text" name="client_secret" class="form-control" id="client_secret" placeholder="Enter Client Secret" value="{{$patho->client_secret ?? ''}}" required>
                                </div>
                                {{-- Store ID --}}
                            <div class="mb-3">
                                <label for="store_id" class="form-label">Store ID</label>
                                <input type="text" name="StoreId" class="form-control" id="store_id" placeholder="Enter Store ID" value="{{$patho->StoreId ?? ''}}"  required>
                            </div>
                          
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="email" name="username" class="form-control" id="username" placeholder="Enter Email"  value="{{$patho->username ?? ''}}"  required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" value="{{ $patho->password ?? ''}}"  required>
                                </div>

                                
                            </div>
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



       

    </div>




</div>
@endsection

@push('scripts')

<!-----

<script>
    $('.toggle-switch').on('change', function () {
    if ($(this).is(':checked')) {
        // Deactivate other switches
        $('.toggle-switch').not(this).prop('checked', false);
    }
});


</script>

--->

@endpush

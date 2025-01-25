@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <div class="card mt-3 col-md-6">
        <div class="card-header">

            <h5 class="mb-3">{{ isset($siteInfo) ? 'Edit Site' : 'Create Site' }}</h5>
            <p class="mb-4">
                {{ isset($siteInfo) ? 'Update your site\'s basic information.' : 'Create your site\'s basic information.' }}
            </p>

        </div>

        <div class="card-body">
            <form action="{{ isset($siteInfo) ? route('admin.manage.storeOrUpdate') : route('admin.manage.storeOrUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
            
                @if (isset($siteInfo))
                    @method('PUT')
                @endif

                <!-- Address -->
                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Store Address</label>
                    <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address', $siteInfo->address ?? '') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                
        
                <!-- Store Phone Number -->
                <div class="col-md-6 mb-3">
                    <label for="store_phone_number" class="form-label">Store Phone Number</label>
                    <input type="text" id="store_phone_number" name="store_phone_number" class="form-control @error('store_phone_number') is-invalid @enderror"
                        value="{{ old('store_phone_number', $siteInfo->store_phone_number ?? '') }}">
                    @error('store_phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Store Gateway Image -->

                <div class="col-md-6 mb-3">
                    <label for="store_gateway_image" class="form-label">Store Gateway Image</label>
                    <input type="file" id="store_gateway_image" name="store_gateway_image" class="form-control @error('store_gateway_image') is-invalid @enderror"
                        value="{{ old('store_gateway_image', $siteInfo->store_gateway_image ?? '') }}">
                    @error('store_gateway_image')

                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

        
                <!-- Store Email -->
                <div class="col-md-6 mb-3">
                    <label for="store_email" class="form-label">Store Email</label>
                    <input type="email" id="store_email" name="store_email" class="form-control @error('store_email') is-invalid @enderror"
                        value="{{ old('store_email', $siteInfo->store_email ?? '') }}">
                    @error('store_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>

        </div>

    </div>
@endsection
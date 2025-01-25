@extends('admin.master')

@section('main-content')
    <div class="page-content">
        <div class="card mt-3">
            <div class="card-header">

                <h5 class="mb-3">{{ isset($siteInfo) ? 'Edit Site' : 'Create Site' }}</h5>
                <p class="mb-4">
                    {{ isset($siteInfo) ? 'Update your site\'s basic information.' : 'Create your site\'s basic information.' }}
                </p>

            </div>

            <!-- Form action dynamic -->
            <div class="card-body">
                <form action="{{ isset($siteInfo) ? route('admin.manage.storeOrUpdate') : route('admin.manage.storeOrUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    @if (isset($siteInfo))
                        @method('PUT')
                    @endif
                
                    <div class="row">
                
                        <!-- App Name -->
                        <div class="col-md-6 mb-3">
                            <label for="app_name" class="form-label">App Name</label>
                            <input type="text" id="app_name" name="app_name" class="form-control @error('app_name') is-invalid @enderror"
                                value="{{ old('app_name', $siteInfo->app_name ?? '') }}" required>
                            @error('app_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Home Page Title -->
                        <div class="col-md-6 mb-3">
                            <label for="home_page_title" class="form-label">Home Page Title</label>
                            <input type="text" id="home_page_title" name="home_page_title" class="form-control @error('home_page_title') is-invalid @enderror"
                                value="{{ old('home_page_title', $siteInfo->home_page_title ?? '') }}" required>
                            @error('home_page_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Product Page Title -->
                        <div class="col-md-6 mb-3">
                            <label for="product_page_title" class="form-label">Product Page Title</label>
                            <input type="text" id="product_page_title" name="product_page_title" class="form-control @error('product_page_title') is-invalid @enderror"
                                value="{{ old('product_page_title', $siteInfo->product_page_title ?? '') }}" required>
                            @error('product_page_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Phone Number -->
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number', $siteInfo->phone_number ?? '') }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- WhatsApp Number -->
                        <div class="col-md-6 mb-3">
                            <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                            <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror"
                                value="{{ old('whatsapp_number', $siteInfo->whatsapp_number ?? '') }}" required>
                            @error('whatsapp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                       
                
                        <!-- Shipping Charge Inside Dhaka -->
                        <div class="col-md-6 mb-3">
                            <label for="shipping_charge_inside_dhaka" class="form-label">Shipping Charge Inside Dhaka</label>
                            <input type="number" step="0.01" id="shipping_charge_inside_dhaka" name="shipping_charge_inside_dhaka"
                                class="form-control @error('shipping_charge_inside_dhaka') is-invalid @enderror"
                                value="{{ old('shipping_charge_inside_dhaka', $siteInfo->shipping_charge_inside_dhaka ?? '') }}">
                            @error('shipping_charge_inside_dhaka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- quantity indicator   -->
                        <div class="col-md-6 mb-3">
                            <label for="quantity_indicator" class="form-label">Quantity Indicator</label>
                            <input type="number" id="quantity_indicator" name="quantity_indicator"
                                class="form-control @error('quantity_indicator') is-invalid @enderror"
                                value="{{ old('quantity_indicator', $siteInfo->quantity_indicator ?? '') }}">
                            @error('quantity_indicator')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Shipping Charge Outside Dhaka -->
                        <div class="col-md-6 mb-3">
                            <label for="shipping_charge_outside_dhaka" class="form-label">Shipping Charge Outside Dhaka</label>
                            <input type="number" step="0.01" id="shipping_charge_outside_dhaka" name="shipping_charge_outside_dhaka"
                                class="form-control @error('shipping_charge_outside_dhaka') is-invalid @enderror"
                                value="{{ old('shipping_charge_outside_dhaka', $siteInfo->shipping_charge_outside_dhaka ?? '') }}">
                            @error('shipping_charge_outside_dhaka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                         <!--checkout_page_text -->
                            <div class="col-md-6 mb-3">
                                <label for="checkout_page_text" class="form-label">Checkout Page Text</label>
                                <input type="text" id="checkout_page_text" name="checkout_page_text"
                                    class="form-control @error('checkout_page_text') is-invalid @enderror"
                                    value="{{ old('checkout_page_text', $siteInfo->checkout_page_text ?? '') }}">
                                @error('checkout_page_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                            
                
                    </div>
                

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                
            </div>
        </div>


    </div>
@endsection

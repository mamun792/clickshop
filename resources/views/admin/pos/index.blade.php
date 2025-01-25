@extends('admin.master')

@section('main-content')
    <div class="page-content">

        <div class="">
            <div class="main-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="fw-bold-400">Order</h5>

                            </div>

                            <div class="card-body">


                                <input type="hidden" id="logged-in-user-id" value="{{ auth()->id() }}">


                                {{-- <div class="bg-primary p-2">
                                    <span style="color: white; font-size: 18px;">Customer Search</span>
                                </div> --}}




                                <div class=" input-group mt-3 d-flex justify-space-between">
                                    <select id="user-search" class="form-control" aria-label="User Search"
                                        aria-describedby="button-addon2">

                                        <option selected value="{{ $user->id }}">
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>


                                    </select>

                                    <button class="btn btn-primary" type="button" id="button-addon2" data-bs-toggle="modal"
                                        data-bs-target="#examplePrimaryModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                        </svg>
                                    </button>

                                </div>






                                <table class="table table-striped mt-3" id="cart-table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Attributes</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{--  no data avaial defualt --}}

                                        <td colspan="5">no data available</td>
                                    </tbody>
                                </table>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <label for="shipping-location" class="form-label">Shipping Location</label>
                                        <select id="shipping-location" class="form-select">

                                            <option selected value="0">Offline</option>
                                            <option value="{{ $deliveryCharges['inside_dhaka'] }}">
                                                Inside Dhaka - {{ $deliveryCharges['inside_dhaka'] }}
                                            </option>
                                            <option value="{{ $deliveryCharges['outside_dhaka'] }}">
                                                Outside Dhaka - {{ $deliveryCharges['outside_dhaka'] }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="discount-input" class="form-label">Fixed Discount</label>
                                        <input type="number" id="discount-input" class="form-control"
                                            placeholder="Enter discount" />
                                    </div>
                                </div>



                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <label for="phone-number" class="form-label">Phone Number</label>
                                        <input type="text" id="phone-number" class="form-control"
                                            placeholder="Enter phone number" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" id="address" class="form-control"
                                            placeholder="Enter address" />
                                    </div>
                                </div>


                                <div class="row mt-3">
                                    <div class="col text-start">
                                        <button type="button" class="btn btn-outline-danger px-5"
                                            onclick="handleclearCart()">
                                            <i class="bx bx-x"></i> Cancel
                                        </button>
                                    </div>
                                    <div class="col text-end">
                                        <button type="button" class="btn btn-primary px-5" onclick="handleCheckout()">
                                            <i class="bx bx-cart"></i> Checkout
                                        </button>
                                    </div>
                                </div>



                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="mb-3">
                            <form method="GET" action="{{ route('admin.pos.manage') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="category" class="form-select form-select-sm">
                                            <option value="">All Categories</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="brand" class="form-select form-select-sm">
                                            <option value="">All Brands</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->company }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-4 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1">Filter</button>
                                        <a href="{{ route('admin.pos.manage') }}"
                                            class="btn btn-danger btn-sm flex-grow-1">Clear</a>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="fw-400">Products</h5>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table align-middle mb-0" id="example">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Items</th>
                                                <th>Attribute Name</th>
                                                <th>Available Qty</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="recent-product-img">
                                                                <img src="{{ asset($product->featured_image) }}"
                                                                    alt="{{ $product->product_name }}">
                                                            </div>
                                                            <div class="ms-2">

                                                                <h6 class="mb-1 font-14 text-truncate"
                                                                    data-bs-toggle="tooltip"
                                                                    title="{{ $product->product_name }}"
                                                                    style="max-width: 200px; white-space: nowrap; overflow: hidden;">
                                                                    {{ $product->product_name }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @include('admin.pos.td_attribute')
                                                    
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>

                                                        <span class="price-display" data-product-id="{{ $product->id }}"
                                                            data-base-price="{{ $product->price }}">
                                                            {{ number_format($product->price, 2) }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1 add-product-btn"
                                                                data-product-id="{{ $product->id }}">
                                                                Add to Cart
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <!-- Hidden campaign discount -->
                                                    <div class="product-campaign" data-product-id="{{ $product->id }}"
                                                        data-discount="{{ $product->product_campaign[0]->campaign->discount ?? 0 }}">
                                                    </div>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>








                                </div>




                            </div>

                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="examplePrimaryModal" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create new User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="register-form" class="row g-3" method="POST"
                        action="{{ route('admin.pos.custom.register') }}"">
                        @csrf
                        <div class="col-md-12">
                            <label for="input1" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="input1"
                                placeholder="First Name">


                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif

                        </div>

                        <!-- <div class="col-md-12">
                            <label for="input4" class="form-label">Email</label>
                            <input type="email" class="form-control" id="input4" placeholder="Email"
                                name="email">

                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div> -->

                        <div class="col-md-12">
                            <label for="input3" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="input3" placeholder="Phone"
                                name="phone">

                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>




                        <!-- <div class="col-md-12">
                            <label for="input19" class="form-label">City</label>
                            <select id="input19" class="form-select" name="city">
                                <option selected="">Choose...</option>
                                <option>Dhaka</option>
                                <option>Chittagong</option>
                                <option>Khulna</option>
                                <option>Rajshahi</option>
                                <option>Barishal</option>
                                <option>Sylhet</option>
                                <option>Rangpur</option>
                                <option>Mymensingh</option>
                            </select>

                            @if ($errors->has('city'))
                                <span class="text-danger">{{ $errors->first('city') }}</span>
                            @endif
                        </div> -->



                        <div class="col-md-12">
                            <label for="input19" class="form-label">Address</label>
                            <textarea class="form-control" name="address"></textarea>

                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>


                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>

                            </div>
                        </div>
                    </form>





                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/Admin/pos/pos.js') }}"></script>
    <script>
        const loggedInUserId = '{{ auth()->user()->id }}';
    </script>
@endpush

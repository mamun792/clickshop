@extends('admin.master')

@section('main-content')
<div class="page-content">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Edit Order</h5>
                    <p>Invoice No: {{$orders->invoice_number}}</p>

                </div>

            </div>

        </div>





        <div class="row">

            <div class="col-md-6">

          
                    <div class="card">
                    <div class="card-header">
                        <h6>Customer Information</h6>

                    </div>
                    </div>

                    <form method="post" action="{{ route('admin.orders.orderInfoUpdate') }}" id="orderForm">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $orders->id }}" />

                        <div class="card-body">

                        <div class="card">
                            <div class="col-md-3">
                                   <!-- Status and Notes -->
                            <div class="form-group mb-3">
                                <label for="order_status">Status</label>
                                <select class="form-select required-field" name="order_status" id="order_status">
                                    @php
                                    $statuses = ['pending', 'processed', 'shipped', 'returned', 'delivered', 'cancelled', 'on delivery', 'pending delivery', 'incomplete'];
                                    @endphp
                                    @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $orders->order_status == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            </div>



                            @if($couriar_settings && $couriar_settings->steadfast == 'yes' || $pathao_couriar_settings && $pathao_couriar_settings->is_enabled == 'yes' || $couriar_settings && $couriar_settings->redx == 'yes')
                            <div class="card">
                            <!-- Quick Courier Send Buttons -->
                            <div class="mb-4 d-flex gap-2">


                                @if ($couriar_settings && $couriar_settings->steadfast == 'yes')
                                @if ($orders->couriar_name == 'steadfast')
                                <button type="button" class="btn btn-primary btn-sm" onclick="validateAndSendToCourier('steadfast')">
                                    Send to Steadfast
                                </button>
                                @endif
                                @endif

                                @if ($pathao_couriar_settings && $pathao_couriar_settings->is_enabled == 'yes')
                                @if ($orders->couriar_name == 'pathao')
                                <button type="button" class="btn btn-success btn-sm" onclick="validateAndSendToCourier('pathao')">
                                    Send to Pathao
                                </button>
                                @endif
                                @endif


                                @if ($couriar_settings && $couriar_settings->redx == 'yes')
                                @if ($orders->couriar_name == 'redx')
                                <button type="button" class="btn btn-info btn-sm" onclick="validateAndSendToCourier('redx')">
                                    Send to RedX
                                </button>
                                @endif
                                @endif

                            </div>
                            </div>
                            @endif

                            
                            <div class="card">
                                <!-- Common Fields -->
                            <div class="form-group mb-3">
                                <label for="name">আপনার নাম</label>
                                <input type="text" class="form-control required-field" name="name" id="name" value="{{ $orders->customer_name }}" />
                            </div>

                            <div class="form-group mb-3">
                                <label for="address">আপনার ঠিকানা</label>
                                <input type="text" class="form-control required-field" name="address" id="address" value="{{ $orders->address }}" />
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone">আপনার মোবাইল</label>
                                <input type="number" class="form-control required-field" name="phone" id="phone" value="{{ $orders->phone_number }}" />
                            </div>


                            <div class="form-group mb-3">
                                <label for="phone">বিকল্প ফোন নম্বর</label>
                                <input type="number" class="form-control required-field" name="alternativephone" id="phone" value="{{ $orders->alternative_phone_number }}" />
                            </div>


                            </div>
                      
                            
                  

                            @if($couriar_settings && $couriar_settings->steadfast == 'yes' || $pathao_couriar_settings && $pathao_couriar_settings->is_enabled == 'yes' || $couriar_settings && $couriar_settings->redx == 'yes')
                            <div class="card">
                            

                            <!-- Courier Selection -->
                            <div class="form-group mb-3">
                                <label for="courier">Select Courier Service</label>
                                <select class="form-select" name="courier" id="courier">
                                    <option value="">Select Courier</option>

                                    @if ($pathao_couriar_settings && $pathao_couriar_settings->is_enabled == 'yes')
                                    <option value="pathao" {{ $orders->couriar_name == 'pathao' ? 'selected' : '' }}>Pathao</option>
                                    @endif
                                    @if ($couriar_settings && $couriar_settings->steadfast == 'yes')
                                    <option value="steadfast" {{ $orders->couriar_name == 'steadfast' ? 'selected' : '' }}>Steadfast</option>
                                    @endif
                                    @if ($couriar_settings && $couriar_settings->redx == 'yes')
                                    <option value="redx" {{ $orders->couriar_name == 'redx' ? 'selected' : '' }}>RedX</option>
                                    @endif

                                </select>
                            </div>

                            <!-- Pathao Specific Fields -->
                            <div id="pathaoFields" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="city">আপনার শহর সিলেক্ট করুন</label>
                                    <select id="city" class="form-select pathao-required" name="city">
                                        <option selected disabled>শহর নির্বাচন করুন</option>
                                        @foreach ($pathao_city as $item)
                                        <option value="{{ $item['city_id'] }}" {{ $item['city_id'] == $orders->city_id ? 'selected' : '' }}>
                                            {{ $item['city_name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="zone">আপনার এলাকা সিলেক্ট করুন</label>
                                    <select class="form-select pathao-required" id="zone" name="zone">
                                        @if ($orders->zone_name)
                                        <option value="{{ $orders->zone_id }}">{{ $orders->zone_name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="area">আপনার নির্দিষ্ট স্থান সিলেক্ট করুন</label>
                                    <select class="form-select pathao-required" id="area" name="area">
                                        @if ($orders->area_name)
                                        <option value="{{ $orders->area_id }}">{{ $orders->area_name }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <!-- RedX Specific Fields -->
                            <div id="redxFields" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="redx_city">City</label>
                                    <select id="redx_city" class="form-select redx-required" name="redex_city">

                                        @if ($orders->city_name)
                                        <option value="{{ $orders->zone_id }}">{{ $orders->city_name }}</option>
                                        @else
                                        <option selected disabled>Select City</option>
                                        @endif

                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="redx_area">Area</label>
                                    <select id="redx_area" class="form-select redx-required" name="redex_area">

                                        @if ($orders->zone_name)
                                        <option value="{{ $orders->zone_id }}">{{ $orders->zone_name }}</option>
                                        @else
                                        <option selected disabled>Select Area</option>
                                        @endif

                                    </select>
                                    <input type="hidden" name="redex_zone" value="" id="zone_id" />
                                </div>
                            </div>


                        

                            <div class="form-group mb-3">
                                <label for="courier_note">Courier Note</label>
                                <textarea class="form-control" name="courier_note" id="courier_note" rows="2">{{ $orders->courier_note ?? '' }}</textarea>
                            </div>
                            
                        </div>


                            @endif

                         

                            <div class="card">
                            <div class="form-group mb-3">
                                <label for="order_note">Order Note</label>
                                <textarea class="form-control" name="note" id="order_note" rows="2">{{ $orders->note ?? '' }}</textarea>
                            </div>

                            <!-- Delivery Area -->
                            <div class="form-group mb-3">
                                <label for="delivery_area">আপনার এরিয়া সিলেক্ট করুন</label>
                                <select class="form-select required-field" name="delivery_charge" id="delivery_area">
                                    <option value="inside" {{ $orders->select_area == 'inside' ? 'selected' : '' }}>ঢাকার ভেতরে</option>
                                    <option value="outside" {{ $orders->select_area == 'outside' ? 'selected' : '' }}>ঢাকার বাহিরে</option>
                                </select>
                            </div>
                            </div>


                            <input type="hidden" id="redux" value="{{json_encode($redux)}}" />




                            <button type="submit" class="btn btn-primary btn-sm w-100">Update</button>
                        </div>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const courierSelect = document.getElementById('courier');
                            const pathaoFields = document.getElementById('pathaoFields');
                            const redxFields = document.getElementById('redxFields');
                            const citySelect = document.getElementById('city');
                            const zoneSelect = document.getElementById('zone');
                            const areaSelect = document.getElementById('area');
                            const redxCitySelect = document.getElementById('redx_city');
                            const redxAreaSelect = document.getElementById('redx_area');

                            // Toggle courier-specific fields visibility
                            courierSelect.addEventListener('change', function() {
                                pathaoFields.style.display = this.value === 'pathao' ? 'block' : 'none';
                                redxFields.style.display = this.value === 'redx' ? 'block' : 'none';

                                if (this.value === 'redx') {
                                    loadRedXCities();
                                }
                            });



                            // Show Pathao fields if Pathao is selected on page load
                            if (courierSelect.value === 'pathao') {
                                pathaoFields.style.display = 'block';
                            }

                            // Load zones when city changes
                            citySelect.addEventListener('change', function() {
                                if (!this.value) return;

                                fetch(`/api/zones/${this.value}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        zoneSelect.innerHTML = '<option selected disabled>এলাকা নির্বাচন করুন</option>';
                                        data.forEach(zone => {
                                            zoneSelect.innerHTML += `<option value="${zone.zone_id}">${zone.zone_name}</option>`;
                                        });
                                    });
                            });

                            // Load areas when zone changes
                            zoneSelect.addEventListener('change', function() {
                                if (!this.value) return;

                                fetch(`/api/areas/${this.value}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        areaSelect.innerHTML = '<option selected disabled>স্থান নির্বাচন করুন</option>';
                                        data.forEach(area => {
                                            areaSelect.innerHTML += `<option value="${area.area_id}">${area.area_name}</option>`;
                                        });
                                    });
                            });

                            // Load unique RedX cities
                            function loadRedXCities() {
                                const reduxElement = document.getElementById('redux');
                                if (!reduxElement) {
                                    console.error('Could not find element with id "redux"');
                                    return;
                                }

                                let reduxData;
                                try {
                                    reduxData = JSON.parse(reduxElement.value);
                                } catch (error) {
                                    console.error('Failed to parse JSON:', error);
                                    return;
                                }

                                if (!Array.isArray(reduxData)) {
                                    reduxData = Object.values(reduxData);
                                }

                                // Ensure unique district_name
                                const uniqueCities = [];
                                const seenDistricts = new Set();
                                reduxData.forEach((city) => {
                                    if (!seenDistricts.has(city.district_name)) {
                                        uniqueCities.push(city);
                                        seenDistricts.add(city.district_name);
                                    }
                                });

                                // Populate unique cities
                                redxCitySelect.innerHTML = '<option selected disabled>Select City</option>';
                                uniqueCities.forEach((city) => {
                                    const option = document.createElement('option');
                                    option.value = city.district_name;
                                    option.textContent = city.district_name;
                                    redxCitySelect.appendChild(option);
                                });
                            }

                            // Handle RedX city selection and load areas
                            redxCitySelect.addEventListener('change', function() {
                                const selectedCity = this.value;
                                if (!selectedCity) return;

                                fetch(`/admin/orders/get-city?district_name=${selectedCity}`)
                                    .then((response) => response.json())
                                    .then((data) => {
                                        redxAreaSelect.innerHTML = '<option selected disabled>Select Area</option>';
                                        data.areas.forEach((area) => {

                                            const option = document.createElement('option');
                                            option.value = area.name;
                                            option.dataset.zoneId = area.id;
                                            option.textContent = area.name;
                                            redxAreaSelect.appendChild(option);
                                        });
                                    });
                            });
                            // Handle RedX city selection and load areas
                            redxAreaSelect.addEventListener('change', function() {


                                document.getElementById('zone_id').value = this.options[this.selectedIndex].dataset.zoneId;


                            });

                            // Validate and send to courier
                            function validateAndSendToCourier(courier) {
                                // Check required fields
                                const requiredFields = document.querySelectorAll('.required-field');
                                let isValid = true;

                                requiredFields.forEach(field => {
                                    if (!field.value) {
                                        isValid = false;
                                        field.classList.add('is-invalid');
                                    } else {
                                        field.classList.remove('is-invalid');
                                    }
                                });

                                // Check courier-specific required fields
                                if (courier === 'pathao') {
                                    const pathaoFields = document.querySelectorAll('.pathao-required');
                                    pathaoFields.forEach(field => {
                                        if (!field.value) {
                                            isValid = false;
                                            field.classList.add('is-invalid');
                                        } else {
                                            field.classList.remove('is-invalid');
                                        }
                                    });
                                } else if (courier === 'redx') {
                                    const redxFields = document.querySelectorAll('.redx-required');
                                    redxFields.forEach(field => {
                                        if (!field.value) {
                                            isValid = false;
                                            field.classList.add('is-invalid');
                                        } else {
                                            field.classList.remove('is-invalid');
                                        }
                                    });
                                }

                                if (!isValid) {
                                    alert('Please fill in all required fields before sending to courier.');
                                    return false;
                                }

                                // Redirect to appropriate courier route
                                const routes = {
                                    pathao: "{{route('admin.orders.pathao', $orders->id)}}",
                                    steadfast: "{{route('admin.orders.steadfast', $orders->id)}}",
                                    redx: "{{route('admin.orders.redx', $orders->id)}}"
                                };

                                if (routes[courier]) {
                                    window.location.href = routes[courier];
                                }
                            }

                            // Attach courier button click handlers
                            document.querySelectorAll('button[onclick^="validateAndSendToCourier"]').forEach(button => {
                                const courier = button.getAttribute('onclick').match(/'([^']+)'/)[1];
                                button.addEventListener('click', () => validateAndSendToCourier(courier));
                            });
                        });
                    </script>

                    <style>
                        .is-invalid {
                            border-color: #dc3545;
                        }
                    </style>

                </div>



       




            {{-- --}}
            <div class="col-md-6">
                {{-- --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="fw-400">Products</h5>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table align-middle mb-0" id="examples">
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
                                        <form action="{{ route('admin.orders.orderNow')}}" method="post">
                                            @csrf
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="recent-product-img">
                                                        <img src="{{ asset($product->featured_image) }}" alt="{{ $product->product_name }}">
                                                    </div>
                                                    <div class="ms-2">
                                                        <h6 class="mb-1 font-14 text-truncate" data-bs-toggle="tooltip"
                                                            title="{{ $product->product_name }}"
                                                            style="max-width: 200px; white-space: nowrap; overflow: hidden;">
                                                            {{ $product->product_name }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <!-- Order structure -->
                                                <input type="hidden" name="order[id]" value="{{ $orders->id }}">

                                                <!-- Item structure -->
                                                <input type="hidden" name="item[product_id]" value="{{ $product->id }}">
                                                <input type="hidden" name="item[quantity]" value="1">
                                                <input type="hidden" name="item[individual_price]" class="individual-price-input" value="{{ $product->price }}">


                                                <!-- Data structure -->
                                                <input type="hidden" name="data[discount_type]" value="fixed">
                                                <input type="hidden" name="data[discount]" value="0">

                                                <!-- Keep campaign discount in data structure -->
                                                <input type="hidden" name="data[campaign_discount]" class="campaign-discount"
                                                    value="{{ $product->product_campaign->campaign->discount ?? 0 }}">

                                                @foreach ($product->product_attributes->groupBy('attribute.name') as $attributeName => $attributes)
                                                <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 10px">
                                                    <span style="text-transform: capitalize">{{ $attributeName }}:</span>
                                                    <select style="border: 1px solid gainsboro; outline: none; margin-left: 10px"
                                                        class="attribute-select"
                                                        data-product-id="{{ $product->id }}"
                                                        data-attribute-name="{{ $attributeName }}"
                                                        name="item[attributeOptionId][]">
                                                        <option value="">Select {{ $attributeName }}</option>
                                                        @foreach ($attributes->unique('attribute_option.id') as $attribute)
                                                        <option class="attribute-option"
                                                            value="{{ $attribute->attribute_option->id }}"
                                                            data-price="{{ $attribute->price }}"
                                                            data-attribute-id="{{ $attribute->attribute_option->id }}"
                                                            data-productattribute-id="{{ $attribute->id }}">
                                                            {{ $attribute->attribute_option->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endforeach
                                            </td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>
                                                <span class="price-display" data-product-id="{{ $product->id }}"
                                                    data-base-price="{{ $product->price }}">
                                                    {{ number_format($product->price, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-3">
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">Order Now</button>
                                                </div>
                                            </td>
                                        </form>
                                    </tr>
                                    @endforeach



                                </tbody>
                            </table>









                        </div>




                    </div>

                </div>

                {{-- ///////////////////////////////// --}}
                <form method="post" action="{{ route('admin.orders.update') }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h6>Product Information</h6>
                            <input type="hidden" name="order_id" value="{{ $orders->id }}" />
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Attribute</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalPrice = 0; @endphp

                                    @foreach ($orders->items as $index => $data)
                                    <tr>
                                        <!-- Index -->
                                        <td>{{ $index + 1 }}</td>

                                        <!-- Product Details -->
                                        <td>
                                            <img src="{{ asset($data->product_info->featured_image) }}" width="60" height="60" alt="Product Image" /><br>
                                            <span title="{{ $data->product_info->product_name }}" style="cursor: pointer;">
                                                {{ Str::limit($data->product_info->product_name, 11, '...') }}
                                            </span><br>
                                            <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $data->product_info->id }}" />
                                            <input type="hidden" name="items[{{ $index }}][order_item_option_id]" value="{{ $data->id }}" />
                                        </td>

                                        <td>
                                            @php
                                            // Decode the JSON string to array
                                            $options = json_decode($data->option, true);

                                            // Group options by attribute type (color, size, etc)
                                            $groupedOptions = collect($options)->groupBy(function ($option) {
                                            return $option['attribute_option']['attribute']['name'];
                                            });
                                            @endphp

                                            @foreach ($groupedOptions as $attributeName => $attributes)
                                            <div class="form-group mb-2">
                                                <label class="font-weight-bold">{{ ucfirst($attributeName) }}:</label>

                                                <select name="items[{{ $index }}][attributes][{{ $attributes->first()['attribute_option']['attribute']['id'] }}][attribute_option_id]"
                                                    class="form-control">
                                                    <option value="{{ $attributes->first()['attribute_option']['id'] }}">
                                                        {{ $attributes->first()['attribute_option']['name'] }}
                                                    </option>
                                                </select>

                                                <!-- Hidden input for order item option id -->
                                                <input type="hidden"
                                                    name="items[{{ $index }}][attributes][{{ $attributes->first()['attribute_option']['attribute']['id'] }}][order_item_option_id]"
                                                    value="{{ $attributes->first()['id'] }}" />
                                            </div>
                                            @endforeach
                                        </td>
                                        <!-- Quantity -->
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger decrease-btn">-</button>
                                            <span class="quantity-display">{{ $data->quantity }}</span>
                                            <input type="hidden" name="items[{{ $index }}][quantity]" class="quantity-input" value="{{ $data->quantity }}" />
                                            <button type="button" class="btn btn-sm btn-success increase-btn">+</button>
                                        </td>

                                        <!-- Price -->
                                        <td class="product-price">
                                            <span class="price-display">{{ $data->price }}</span>
                                            <input type="hidden" name="items[{{ $index }}][price]" value="{{ $data->price }}" />
                                        </td>
                                        <td>

                                            <button type="button" class="btn btn-danger btn-sm remove-item" data-item-id="{{ $data->id }}" data-item-quantity="{{ $data->quantity }}">Remove</button>
                                        </td>

                                    </tr>

                                    @php
                                    $totalPrice += $data->price * $data->quantity;
                                    @endphp
                                    @endforeach
                                </tbody>

                                {{-- <tfoot>
                                        <tr>
                                            <td colspan="4">Delivery Charge:</td>
                                            <td colspan="2" id="delivery-charges">{{ $orders->delivery_charge }}</td>
                                <input type="hidden" id="delivery" name="delivery_charge" value="{{ $orders->delivery_charge }}" />
                                </tr>
                                <tr>
                                    <td colspan="4">Discount :</td>
                                    <td colspan="2" id="delivery-charges">
                                        <input type="number" name="discount" value="{{ $orders->discount ?? 0}}" />
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="4">Total Price:</td>
                                    <td colspan="2" id="total-price">{{ $totalPrice + $orders->delivery_charge }}</td>
                                    <input type="hidden" id="total-price-val" name="total_price" value="{{ $totalPrice + $orders->delivery_charge }}" />
                                </tr>
                                </tfoot> --}}

                                <tfoot>
                                    <tr>
                                        <td colspan="4">Delivery Charge:</td>
                                        <td colspan="2" id="delivery-charges">{{ $orders->delivery_charge }}</td>
                                        <input type="hidden" id="delivery" name="delivery_charge" value="{{ $orders->delivery_charge }}" />
                                    </tr>
                                    <tr>
                                        <td colspan="4">Discount :</td>
                                        <td colspan="2" id="delivery-charges">
                                            -<input type="number" name="discount" value="{{ $orders->discount ?? 0}}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Total Price:</td>
                                        <td colspan="2" id="total-price">{{ $orders->total_price + $orders->delivery_charge }}</td>
                                        <input type="hidden" id="total-price-val" name="total_price" value="{{ $totalPrice + $orders->delivery_charge }}" />
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary btn-sm w-100" type="submit">Update</button>
                        </div>
                    </div>
                </form>





            </div>





        </div>

        @include('admin.orders.dublicateordertable')







    </div>

</div>



</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/Admin/order/order.js') }}"></script>
@endpush
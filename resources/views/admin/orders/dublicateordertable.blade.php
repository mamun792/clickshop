

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="table-responsive">



                        <table class="table table-striped my-table2" id="cexample">
                            <thead>
                                <tr>



                                    <th>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="selectAll">
                                            Date
                                        </div>
                                    </th>



                                    <th> Customer Info </th>
                                    <th> Product Info </th>
                                    <th> Total Price </th>
                                    <th> Order Status </th>
                                    <th> Order Note </th>
                                    <th> Courier Status</th>
                                    <th> Comment </th>
                                    <th class="last1"> Success Rate</th>
                                    <th class="last2">Action</th>
                                </tr>
                            </thead>
                            <tbody>




                                @foreach ($duplicateorders as $index => $order)
                                <tr>



                                    <td style="width: 10%">
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input order-checkbox" type="checkbox"
                                                value="{{ $order->id }}">
                                            <label class="form-check-label fw-bold">
                                                <span
                                                    class="text-primary">{{ $order->created_at->format('d-m-Y') }}</span>
                                            </label>
                                            <br>
                                            <small
                                                class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                            <br />
                                            <span class="badge bg-success">Invoice:
                                                {{ $order->invoice_number }}</span>
                                        </div>
                                    </td>




                                    <td style="width: 10%">
                                        <div
                                            style="display: flex; align-items: center; justify-content: flex-start; gap: 10px">

                                            <div>
                                                {{-- Use the @avatar directive --}}
                                                @if ($order->customer_info['image'])
                                                <img src="{{ asset($order->customer_info['image']) }}"
                                                    width="25" height="25" />
                                                @else
                                                <img src="@avatar($order->customer_info['image'], $order->customer_info->name)" width="25" height="25"
                                                    alt="Customer Avatar" />
                                                @endif
                                            </div>

                                            <div>
                                                <span>
                                                    {{-- icon of avater --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                        height="15" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <circle cx="12" cy="7" r="4"></circle>
                                                        <path d="M5.5 21a8.38 8.38 0 0 1 13 0"></path>
                                                    </svg>



                                                    {{ Str::limit($order->customer_info->name, 11, '...') }}
                                                </span><br>
                                                <span>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                        height="15" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path
                                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.88 19.88 0 0 1-8.63-3.25 19.88 19.88 0 0 1-6.87-6.87A19.88 19.88 0 0 1 2.08 4.18 2 2 0 0 1 4 2h3a2 2 0 0 1 2 1.72 12.07 12.07 0 0 0 .5 2.27 2 2 0 0 1-.45 2L7.1 9.1a16 16 0 0 0 8.36 8.36l1.45-1.45a2 2 0 0 1 2-.45 12.07 12.07 0 0 0 2.27.5 2 2 0 0 1 1.72 2z">
                                                        </path>
                                                    </svg>



                                                    {{ $order->phone_number }}</span><br>
                                                <span title="{{ $order->address }}" style="cursor: pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                        height="15" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path
                                                            d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7z">
                                                        </path>
                                                        <circle cx="12" cy="9" r="2.5"></circle>
                                                    </svg>


                                                    {{ Str::limit($order->address, 11, '...') }}
                                                </span>
                                            </div>

                                        </div>
                                    </td>



                                    <td style="width: 10%">
                                        <div
                                            style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                                            @foreach ($order['items'] as $item)
                                            <div
                                                style="display: flex; align-items: center; gap: 10px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                                <div>
                                                    <img src="{{ asset($item['product_info']['featured_image']) }}"
                                                        width="50" height="50" />
                                                </div>
                                                <div>
                                                    <span title="{{ $item['product_info']['product_name'] }}"
                                                        style="cursor: pointer;">
                                                        {{ Str::limit($item['product_info']['product_name'], 11, '...') }}
                                                    </span><br>
                                                    <span>Code:
                                                        {{ Str::limit($item['product_info']['product_code'], 5, '...') }}</span><br>
                                                    <span>Quantity: {{ $item['quantity'] }}</span><br>
                                                    @foreach ($item['option'] as $option)
                                                    <span>{{ $option['attributeOption']['attribute']['name'] }}:
                                                        {{ $option['attributeOption']['name'] }}</span><br>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td style="width: 10%">
                                        <span>{{ $order->total_price }}</span>
                                    </td>
                                    <td style="width: 10%">
                                        <style>
                                            .status-select-container {
                                                position: relative;
                                                width: 100%;
                                                font-family: system-ui, -apple-system, sans-serif;
                                            }

                                            .status-select {
                                                appearance: none;
                                                width: 100%;
                                                padding: 0.625rem 2rem 0.625rem 1rem;
                                                font-size: 0.875rem;
                                                line-height: 1.5;
                                                border-radius: 0.5rem;
                                                border: 1px solid #e2e8f0;
                                                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
                                                background-repeat: no-repeat;
                                                background-position: right 0.5rem center;
                                                background-size: 1.2em;
                                                cursor: pointer;
                                                transition: all 0.2s ease;
                                                font-weight: 500;
                                            }

                                            .status-select:focus {
                                                outline: none;
                                                box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
                                            }

                                            /* Softer, more professional colors */
                                            #orderStatus {
                                                background-color: #f7f7f7;
                                            }

                                            /* Status-specific styles with softer colors */
                                            #orderStatus option[value="pending"] {
                                                background-color: #FFF8E6;
                                                color: #916800;
                                            }

                                            #orderStatus option[value="processed"] {
                                                background-color: #FFF1E7;
                                                color: #6d2c00;
                                            }

                                            #orderStatus option[value="shipped"] {
                                                background-color: #E6F6F4;
                                                color: #0F766E;
                                            }

                                            #orderStatus option[value="delivered"] {
                                                background-color: #ECFDF5;
                                                color: #003013;
                                            }

                                            #orderStatus option[value="cancelled"] {
                                                background-color: #FEE2E2;
                                                color: #991B1B;
                                            }

                                            #orderStatus option[value="returned"] {
                                                background-color: #EFF6FF;
                                                color: #1E40AF;
                                            }

                                            #orderStatus option[value="on delivery"] {
                                                background-color: #EEF2FF;
                                                color: #07006d;
                                            }

                                            #orderStatus option[value="pending delivery"] {
                                                background-color: #F5F3FF;
                                                color: #5B21B6;
                                            }

                                            #orderStatus option[value="incomplete"] {
                                                background-color: #FDF2F8;
                                                color: #9D174D;
                                            }

                                            .status-badge {
                                                display: inline-flex;
                                                align-items: center;
                                                padding: 0.375rem 0.75rem;
                                                border-radius: 0.375rem;
                                                font-weight: 500;
                                                font-size: 0.875rem;
                                                line-height: 1.25;
                                            }

                                            .status-select:hover {
                                                border-color: #CBD5E0;
                                                background-color: inherit;
                                                /* Maintain current background color */
                                                color: inherit;
                                                /* Maintain current text color */
                                            }
                                        </style>

                                        <div class="status-select-container">
                                            <select class="status-select" data-order-id="{{ $order->id }}"
                                                name="order_status" aria-label="Update Order Status">
                                                <option value="pending"
                                                    style="background-color: #FFF8E6; color: #916800;"
                                                    {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="processed"
                                                    style="background-color: #FFF1E7; color: #C54E00;"
                                                    {{ $order->order_status == 'processed' ? 'selected' : '' }}>
                                                    Processed</option>
                                                <option value="shipped"
                                                    style="background-color: #E6F6F4; color: #0F766E;"
                                                    {{ $order->order_status == 'shipped' ? 'selected' : '' }}>
                                                    Shipped</option>
                                                <option value="delivered"
                                                    style="background-color: #ECFDF5; color: #166534;"
                                                    {{ $order->order_status == 'delivered' ? 'selected' : '' }}>
                                                    Delivered</option>
                                                <option value="cancelled"
                                                    style="background-color: #FEE2E2; color: #991B1B;"
                                                    {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled</option>
                                                <option value="returned"
                                                    style="background-color: #EFF6FF; color: #1E40AF;"
                                                    {{ $order->order_status == 'returned' ? 'selected' : '' }}>
                                                    Returned</option>
                                                <option value="on delivery"
                                                    style="background-color: #EEF2FF; color: #3730A3;"
                                                    {{ $order->order_status == 'on delivery' ? 'selected' : '' }}>
                                                    On Delivery</option>
                                                <option value="pending delivery"
                                                    style="background-color: #F5F3FF; color: #5B21B6;"
                                                    {{ $order->order_status == 'pending delivery' ? 'selected' : '' }}>
                                                    Pending Delivery</option>
                                                <option value="incomplete"
                                                    style="background-color: #FDF2F8; color: #9D174D;"
                                                    {{ $order->order_status == 'incomplete' ? 'selected' : '' }}>
                                                    Incomplete</option>
                                            </select>
                                        </div>


                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Find all status select elements
                                                const statusSelects = document.querySelectorAll('.status-select');

                                                statusSelects.forEach(select => {
                                                    // Apply initial styles for the selected option
                                                    applyStyles(select);

                                                    // Add change event listener to each select
                                                    select.addEventListener('change', function() {
                                                        const orderId = this.getAttribute('data-order-id');
                                                        handleStatusChange(this, orderId);
                                                        applyStyles(this);
                                                    });
                                                });

                                                function applyStyles(select) {
                                                    const selectedOption = select.options[select.selectedIndex];
                                                    select.style.backgroundColor = selectedOption.style.backgroundColor;
                                                    select.style.color = selectedOption.style.color;
                                                }

                                                function handleStatusChange(select, orderId) {

                                                    // Prevent unnecessary calls and ensure single execution
                                                    if (select.dataset.updating === 'true') return;
                                                    select.dataset.updating = 'true';

                                                    // Show loading state
                                                    select.style.opacity = '0.7';

                                                    fetch('/admin/orders/updatestatus', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                                            },
                                                            body: JSON.stringify({
                                                                order_id: orderId,
                                                                status: select.value
                                                            })
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            select.style.opacity = '1';
                                                            select.dataset.updating = 'false';
                                                            if (!data.success) throw new Error('Update failed');



                                                            showFeedback(select, 'success');
                                                            //swit alert
                                                            Swal.fire({
                                                                position: 'top-end',
                                                                icon: 'success',
                                                                title: 'Your work has been saved',
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                            })

                                                        })
                                                        .catch(error => {
                                                            select.style.opacity = '1';
                                                            select.dataset.updating = 'false';
                                                            console.error('Error updating status:', error);
                                                            showFeedback(select, 'error');
                                                        });
                                                }

                                                function showFeedback(select, type) {
                                                    const container = select.closest('.status-select-container');
                                                    const indicator = document.createElement('div');
                                                    indicator.className = `status-indicator ${type}`;
                                                    indicator.style.cssText = `position: absolute;right: -10px;top: -10px;background-color: ${type === 'success' ? '#34D399' : '#EF4444'};border-radius: 50%;width: 20px;height: 20px;opacity: 0;transition: opacity 0.2s ease;`;

                                                    container.appendChild(indicator);
                                                    requestAnimationFrame(() => (indicator.style.opacity = '1'));

                                                    setTimeout(() => {
                                                        indicator.style.opacity = '0';
                                                        setTimeout(() => indicator.remove(), 200);
                                                    }, 1500);
                                                }
                                            });
                                        </script>


                                    </td>`

                                    <td style="width: 10% ;text-align:center">
                                        <span class="badge px-3"
                                            style="font-weight: 200;color:black;text-align:center"
                                            id="note{{ $order->id }}">{{ $order->note }}</span>
                                        <div class="text-center">
                                            <button type="button" style="margin:auto"
                                                class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#ordernote">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                    height="16" fill="currentColor"
                                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>

                                            </button>
                                        </div>
                                    </td>


                                    <td style="width: 10%">

                                        <div>
                                            @if ($order->couriar_name == 'steadfast')
                                            <a style="text-decoration: underline" target="_blank"
                                                href="{{ $order->tracking_code }}">Tracking</a>
                                            <span class="badge bg-success">Steadfast</span>
                                            @elseif($order->couriar_name == 'redx')
                                            <a style="text-decoration: underline" target="_blank"
                                                href="https://redx.com.bd/track-parcel/?trackingId={{ $order->consignment_id }}">Tracking</a>
                                            <span class="badge bg-danger">Redx</span>
                                            @elseif($order->couriar_name == 'pathao')
                                            <a style="text-decoration: underline" target="_blank"
                                                href="https://merchant.pathao.com/tracking?consignment_id={{ $order->consignment_id }}">Tracking</a>
                                            <span class="badge bg-primary">Pathao</span>
                                            @else
                                            <span class="badge bg-secondary">N/A</span>
                                            @endif
                                            <br>
                                        </div>

                                    </td>


                                    <td style="width: 10%">
                                        <div class="text-center" id="comment{{ $order->id }}">
                                            @if ($order->comment_id)
                                            {{ $order->comment->name }}
                                            @else
                                            <span>N/A</span>
                                            @endif

                                        </div>

                                        <div class="text-center">
                                            <button type="button" style="margin:auto"
                                                class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#exampleVerticallycenteredModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                    height="16" fill="currentColor"
                                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>

                                            </button>
                                        </div>

                                    </td>




                                    <td style="width: 10%;text-align:center" class="last1">

                                        <button type="button" class="btn btn-secondary btn-sm"
                                            style="background: rebeccapurple;padding: 4px 4px;display: flex; align-items: center;justify-content: center;text-align: center;margin: auto;"
                                            data-bs-toggle="modal" data-bs-target="#froatchecker">
                                            Check
                                        </button>
                                        <!-- froatchecker Note Modal -->
                                        <div class="modal fade" id="froatchecker" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Froude Checker</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Here wll be the Froude result
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>


                                    <td style="width: 10%" class="last2">

                                        <a class="" style="font-weight: 300"
                                            href="{{ route('admin.orders.show', $order->id) }}">

                                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                                style="background-color: #a3ffed91;border-color: #a3ffed91;">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" height="15px"
                                                    width="15px" version="1.1" id="Capa_1"
                                                    viewBox="0 0 460 460" xml:space="preserve">
                                                    <g>
                                                        <path style="fill:#FFFFFF;"
                                                            d="M110.099,230c0-43.966,25.491-82.397,61.976-103.267C120.489,142.547,74.985,179.07,45.43,230   c29.551,50.923,75.047,87.443,126.625,103.261C135.581,312.383,110.099,273.958,110.099,230z" />
                                                        <path style="fill:#6BE0F4;"
                                                            d="M294.369,128.828c33.386,21.289,55.532,58.638,55.532,101.172   c0,42.542-22.154,79.896-55.549,101.178c48.93-16.8,91.896-52.374,120.218-101.178C386.252,181.202,343.292,145.63,294.369,128.828   z" />
                                                        <path style="fill:#0B389C;"
                                                            d="M349.901,230c0-42.535-22.146-79.883-55.532-101.172c-19.98-6.862-40.955-10.586-62.333-10.81   v57.199c1.453,0,2.882,0.074,4.298,0.186c5.696-11.007,16.625-18.447,30.188-18.447c20.136,0,36.522,16.386,36.522,36.522   c0,13.57-7.448,25.429-18.466,31.725c0.127,1.582,0.205,3.18,0.205,4.797c0,30.204-22.543,54.783-52.747,54.783v57.199   c21.372-0.223,42.341-3.946,62.316-10.804C327.747,309.896,349.901,272.542,349.901,230z" />
                                                        <path style="fill:#4370D9;"
                                                            d="M175.217,230c0-30.204,26.615-54.783,56.819-54.783v-57.199C231.357,118.011,230.679,118,230,118   c-19.793,0-39.257,3.011-57.924,8.733c-36.486,20.869-61.976,59.3-61.976,103.267c0,43.958,25.481,82.383,61.956,103.261   C190.729,338.987,210.2,342,230,342c0.679,0,1.357-0.011,2.036-0.018v-57.199C201.833,284.783,175.217,260.204,175.217,230z" />
                                                        <path style="fill:#07215C;"
                                                            d="M175.217,230c0,30.204,26.615,54.783,56.819,54.783s52.747-24.579,52.747-54.783   c0-1.617-0.078-3.215-0.205-4.797c-5.33,3.046-11.491,4.797-18.056,4.797c-20.136,0-34.486-16.386-34.486-36.521   c0-6.573,1.538-12.741,4.298-18.075c-1.416-0.112-2.845-0.186-4.298-0.186C201.833,175.217,175.217,199.796,175.217,230z" />
                                                        <path style="fill:#FFFFFF;"
                                                            d="M266.522,230c6.565,0,12.726-1.751,18.056-4.797c11.017-6.296,18.466-18.154,18.466-31.725   c0-20.136-16.386-36.522-36.522-36.522c-13.563,0-24.492,7.44-30.188,18.447c-2.76,5.334-4.298,11.502-4.298,18.075   C232.036,213.614,246.386,230,266.522,230z" />
                                                        <path style="fill:#EF9E8F;"
                                                            d="M45.43,230c29.555-50.93,75.059-87.453,126.646-103.267C190.743,121.011,210.207,118,230,118   c0.679,0,1.357,0.011,2.036,0.018c21.378,0.223,42.353,3.948,62.333,10.81C343.292,145.63,386.252,181.202,414.57,230H460   l-4.88-9.29c-22.27-42.44-54.36-78.08-92.8-103.07C322.41,91.71,276.66,78,230,78s-92.41,13.71-132.31,39.64   c-38.45,24.99-70.54,60.63-92.81,103.07L0,230H45.43z" />
                                                        <path style="fill:#F57B71;"
                                                            d="M414.57,230c-28.321,48.804-71.288,84.378-120.218,101.178   c-19.975,6.858-40.944,10.581-62.316,10.804C231.357,341.989,230.679,342,230,342c-19.8,0-39.271-3.013-57.945-8.739   C120.477,317.443,74.981,280.923,45.43,230H0l4.88,9.29c22.27,42.44,54.36,78.08,92.81,103.07C137.59,368.29,183.34,382,230,382   s92.41-13.71,132.32-39.64c38.44-24.99,70.53-60.63,92.8-103.07L460,230H414.57z" />
                                                    </g>
                                                </svg>
                                            </button>

                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="col">
                                            <button type="button" class="btn btn-primary  btn-sm">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                    height="16" fill="currentColor"
                                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>

                                            </button>
                                        </a>

                                        <a class="btn btn-danger btn-sm deleteButton"
                                            href="{{ route('admin.orders.delete', $order->id) }}"
                                            class="dropdown-item">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash3-fill"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                            </svg>
                                        </a>


                                    </td>




                                </tr>

                                <!-- Comment Modal -->
                                <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Manage Comments</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form to Add a New Comment -->
                                                <form id="addCommentForm" method="POST">
                                                    @csrf
                                                    <div id="addCommentSuccessMessage"
                                                        class="alert alert-success d-none"></div>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Add New
                                                            Comment</label>
                                                        <input type="text" name="name" class="form-control"
                                                            id="commentName" placeholder="Enter comment name">
                                                        <div id="nameError" class="invalid-feedback"></div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm">Add
                                                        Comment</button>
                                                </form>

                                                <hr>

                                                <!-- Form to Select and Associate Comment with Order -->
                                                <form id="associateCommentForm" method="POST">
                                                    @csrf
                                                    <div id="associateCommentSuccessMessage"
                                                        class="alert alert-success d-none"></div>
                                                    <input type="hidden" name="order_id"
                                                        value="{{ $order->id }}">
                                                    <div class="mb-3">
                                                        <label for="comment_id" class="form-label">Select Existing
                                                            Comment</label>
                                                        <select class="form-select" name="comment_id"
                                                            id="commentSelect">
                                                            <option selected disabled>Select or change a comment
                                                            </option>
                                                            @foreach ($comments as $comment)
                                                            <option value="{{ $comment->id }}">
                                                                {{ $comment->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary btn-sm">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Note Modal -->
                                <div class="modal fade" id="ordernote" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Order Note</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form id="orderNoteForm" method="post">
                                                @csrf
                                                <div id="orderNoteSuccessMessage"
                                                    class="alert alert-success d-none"></div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="order_id"
                                                        value="{{ $order->id }}">
                                                    <div class="mb-3">
                                                        <label for="note" class="form-label">Note</label>
                                                        <textarea name="note" class="form-control" id="noteText" cols="30" rows="5"
                                                            placeholder="Enter your note here">{{ $order->note }}</textarea>
                                                        <div id="noteError" class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit"
                                                        class="btn btn-primary btn-sm">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Helper function to display success messages
                                    // Helper function to display success messages
                                    function displaySuccessMessage(containerId, message) {
                                        const container = document.getElementById(containerId);
                                        container.textContent = message;
                                        container.classList.remove('d-none');
                                        setTimeout(() => {
                                            container.classList.add('d-none');
                                        }, 3000); // Hide message after 3 seconds
                                    }

                                    // Helper function to refresh comment dropdown with all comments
                                    function refreshCommentDropdown(comments) {
                                        const commentSelect = document.getElementById('commentSelect');
                                        // Keep the default "Select or change a comment" option
                                        const defaultOption = commentSelect.options[0];
                                        // Clear existing options
                                        commentSelect.innerHTML = '';
                                        // Add back the default option
                                        commentSelect.appendChild(defaultOption);

                                        // Add all comments to the dropdown
                                        comments.forEach(comment => {
                                            const option = document.createElement('option');
                                            option.value = comment.id;
                                            option.textContent = comment.name;
                                            commentSelect.appendChild(option);
                                        });
                                    }

                                    // Helper function to update comment display on main page
                                    function updateCommentDisplay(orderId, commentText) {
                                        const commentElement = document.getElementById(`comment${orderId}`);
                                        if (commentElement) {
                                            commentElement.innerText = commentText;
                                        }
                                    }

                                    // Helper function to update note display on main page
                                    function updateNoteDisplay(orderId, noteText) {
                                        const noteElement = document.getElementById(`note${orderId}`);
                                        if (noteElement) {
                                            noteElement.innerText = noteText || ''; // Handle empty notes
                                        }
                                    }

                                    // AJAX for Add Comment Form
                                    document.getElementById('addCommentForm').addEventListener('submit', function(e) {
                                        e.preventDefault();
                                        const formData = new FormData(this);

                                        fetch("{{ route('admin.orders.ordercommentadd') }}", {
                                                method: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                                },
                                                body: formData
                                            })
                                            .then(response => response.json())
                                            .then(comments => {
                                                if (Array.isArray(comments)) {
                                                    displaySuccessMessage('addCommentSuccessMessage', 'Comment added successfully!');
                                                    // Refresh dropdown with all comments
                                                    refreshCommentDropdown(comments);
                                                    this.reset();
                                                    // Clear any previous error states
                                                    document.getElementById('commentName').classList.remove('is-invalid');
                                                    document.getElementById('nameError').textContent = '';
                                                } else {
                                                    // Handle error case
                                                    document.getElementById('nameError').textContent = 'Error adding comment';
                                                    document.getElementById('commentName').classList.add('is-invalid');
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                                alert('An error occurred while adding the comment');
                                            });
                                    });

                                    // AJAX for Associate Comment Form
                                    document.getElementById('associateCommentForm').addEventListener('submit', function(e) {
                                        e.preventDefault();
                                        const formData = new FormData(this);
                                        const orderId = formData.get('order_id');
                                        const commentSelect = document.getElementById('commentSelect');
                                        const selectedCommentText = commentSelect.options[commentSelect.selectedIndex].text;

                                        fetch("{{ route('admin.orders.orderComment') }}", {
                                                method: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                                },
                                                body: formData
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    displaySuccessMessage('associateCommentSuccessMessage',
                                                        'Comment associated successfully!');
                                                    // Update the comment display on the main page
                                                    updateCommentDisplay(orderId, selectedCommentText);
                                                    // Close modal after successful update
                                                    bootstrap.Modal.getInstance(document.getElementById('exampleVerticallycenteredModal'))
                                                        .hide();
                                                } else {
                                                    alert('Error associating comment!');
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                                alert('An error occurred while associating the comment');
                                            });
                                    });

                                    // AJAX for Order Note Form
                                    document.getElementById('orderNoteForm').addEventListener('submit', function(e) {
                                        e.preventDefault();
                                        const formData = new FormData(this);
                                        const orderId = formData.get('order_id');
                                        const noteText = formData.get('note');

                                        fetch("{{ route('admin.orders.ordernote') }}", {
                                                method: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                                },
                                                body: formData
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    displaySuccessMessage('orderNoteSuccessMessage', 'Note saved successfully!');
                                                    // Update the note display on the main page
                                                    updateNoteDisplay(orderId, noteText);
                                                    // Clear any previous error states
                                                    document.getElementById('noteText').classList.remove('is-invalid');
                                                    document.getElementById('noteError').textContent = '';
                                                    // Close modal after successful update
                                                    bootstrap.Modal.getInstance(document.getElementById('ordernote')).hide();
                                                } else {
                                                    document.getElementById('noteError').textContent = data.errors.note || '';
                                                    document.getElementById('noteText').classList.add('is-invalid');
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                                alert('An error occurred while saving the note');
                                            });
                                    });
                                </script>
                                @endforeach







                            </tbody>
                        </table>



                    </div>

                </div>
            </div>
        </div>
    </div>
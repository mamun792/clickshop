

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
                                    <th> Comment </th>
                                    <th class="last1"> Success Rate</th>
                                    <th class="last2">Action</th>
                                </tr>
                            </thead>
                            <tbody>




                                @foreach ($orders as $index => $order)
                                <tr>



                                    <td style="width: 10%" class="text-wrap">
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




                                    <td style="width: 10%" class="text-wrap">
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


                                                   {{$order->address}}
                                                </span>
                                            </div>

                                        </div>
                                    </td>



                                    @include('admin.orders.table.td_order_product_info')

                                    <td style="width: 10%" class="text-wrap">
                                        <span>{{ $order->total_price }}</span>
                                    </td>
                                   
                                    @include('admin.orders.table.td_order_status')
                                    @include('admin.orders.table.td_order_note')
                                 


                              


                          


                                    @include('admin.orders.table.td_order_comment')
                                    @include('admin.orders.table.td_order_froudecheker')
                                    @include('admin.orders.table.td_order_action')
                                






                                </tr>

                               
                                @endforeach







                            </tbody>
                        </table>



                    </div>

                </div>
            </div>
        </div>
    </div>
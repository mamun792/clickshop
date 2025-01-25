<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">

        <div class="col">
            <div class="card radius-10 status-card active" data-status="">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Order</p>
                            <h4 class="my-1">{{ $total_order }}</h4>

                        </div>
                        <div class="widgets-icons rounded-circle text-white ms-auto ">
                            <img src="{{ asset('uploads/Total Order.png') }}" width="40" height="40" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 status-card" data-status="pending">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Pending Order</p>
                            <h4 class="my-1">{{ $pending_order }}</h4>

                        </div>
                        <div class="widgets-icons rounded-circle text-white ms-auto">
                            <img src="{{ asset('uploads/pending order.png') }}" width="40" height="40" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 status-card" data-status="processed">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Processed Order</p>
                            <h4 class="my-1">{{ $processed_order }}</h4>

                        </div>
                        <div class="widgets-icons rounded-circle text-white ms-auto">
                            <img src="{{ asset('uploads/Processed Orders.png') }}" width="40" height="40" />

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 status-card" data-status="shipped">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">On Delivary</p>
                            <h4 class="my-1">{{ $shipped_order }}</h4>

                        </div>
                        <div class="widgets-icons rounded-circle text-white ms-auto">
                            <img src="{{ asset('uploads/fast-delivery.png') }}" width="40" height="40" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 status-card" data-status="on delivery">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Courier Orders</p>
                            <h4 class="my-1">{{ $on_delivary }}</h4>

                        </div>
                        <div class="widgets-icons rounded-circle text-white ms-auto">
                            <img src="{{ asset('uploads/On Delivery Order.png') }}" width="40" height="40" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------------- second row start ----------------------------------------------------->

        <div class="col">
            <div class="card radius-10 status-card" data-status="delivered">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Delivered Orders</p>
                            <h4 class="my-1">{{ $delivered_order }}</h4>

                        </div>
                        <div class="widgets-icons rounded-circle text-white ms-auto">

                            <img src="{{ asset('uploads/Delivered Order.png') }}" width="40" height="40" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 status-card" data-status="cancelled">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Cancelled Orders</p>
                            <h4 class="my-1">{{ $cancelled_order }}</h4>

                        </div>
                        <div class="widgets-icons rounded-circle text-white ms-auto ">
                            <img src="{{ asset('uploads/cancelled Order.png') }}" width="40" height="40" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 status-card" data-status="returned">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Return Orders</p>
                            <h4 class="my-1">{{ $returned_order }}</h4>

                        </div>
                        <div class="widgets-icons rounded-circle text-white ms-auto">
                            <img src="{{ asset('uploads/return orders.png') }}" width="40" height="40" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!------------------------------------------------- second row end ----------------------------------------------------->
    </div>
    <!--end row-->
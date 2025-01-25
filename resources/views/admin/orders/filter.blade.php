  <!----------------------------- feltering saty  ----------------------------------->

  <div class="card">

<div class="card-header" id="toggleCard" style="cursor: pointer;">
    <h6 class="card-title">Filtered Area</h6>
</div>


<div class="card-body" id="filterForm" style="display: none;">


    <form method="get" action="{{ route('admin.orders.index') }}">

        @csrf



        <div class="row gx-3 gy-2 align-items-center">
            <!-- Product Code -->
            <div class="col-md-2">
                <label for="productCode" class="form-label">Product Code</label>
                <input type="text" id="productCode" name="product_code" class="form-control form-control-sm"
                    placeholder="Enter Product Code">
            </div>

            <!-- Invoice Number -->
            <div class="col-md-2">
                <label for="invoice" class="form-label">Invoice</label>
                <input type="text" id="invoice" name="invoice" class="form-control form-control-sm"
                    placeholder=" Enter invoice">
            </div>

            <!-- Phone Number -->
            <div class="col-md-2">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" id="phone" name="phone" class="form-control form-control-sm"
                    placeholder="Enter phone">
            </div>

            <!-- Status -->
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>

                <select class="form-select form-select-sm" id="status" name="status"
                    aria-label=".form-select-sm example">
                    <option selected disabled> Select Option</option>
                    <option value="pending">Pending</option>
                    <option value="processed">Processed</option>
                    {{-- <option value="Shipped">Shipped</option> --}}
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>

                    <option value="returned">Returned</option>
                </select>
            </div>

            <!-- dayby select -->


            <div class="col-md-2">
                <label for="day" class="form-label">Day</label>
                <select class="form-select form-select-sm" id="day" name="day"
                    aria-label=".form-select-sm example">
                    <option selected disabled> Select Option</option>
                    <option value="1">Today</option>
                    <option value="2">Yesterday</option>
                    <option value="3">Last 7 days</option>
                    <option value="4">Last 30 days</option>
                    <option value="5">This month</option>
                    <option value="6">Last month</option>
                </select>
            </div>







            <!-- Days -->
            <div class="col-md-2">
                <label for="dateRange" class="form-label">From</label>
                <div class="input-group input-group-sm">

                    <input type="date" id="dateFrom" name="date_from" class="form-control">

                </div>
            </div>

            <!-- Days -->
            <div class="col-md-2">
                <label for="dateRange" class="form-label">To</label>
                <div class="input-group input-group-sm">

                    <input type="date" id="dateTo" name="date_to" class="form-control">

                </div>
            </div>

            <!-- customer name -->

            <div class="col-md-2">
                <label for="status" class="form-label">Customer Name</label>
                <input type="text" id="customerName" name="customer_name"
                    class="form-control form-control-sm" placeholder="Enter status">
            </div>

            <!-- courier name -->

            <div class="col-md-2">
                <label for="status" class="form-label">Courier Name</label>
                <input type="text" id="courierName" name="courier_name"
                    class="form-control form-control-sm" placeholder="Enter status">
            </div>


            <!-- Filter and Reset Buttons -->
            <div class="col-md-2 align-self-end mt-3">
                <button type="submit" class="btn btn-primary btn-sm me-2"
                    onclick="applyFilters()">Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-dark btn-sm">Reset</a>
            </div>
        </div>

    </form>

    <hr>



</div>



</div>
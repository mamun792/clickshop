@foreach($orders as $index => $order)
<style>
    @page {
        margin: 0;
        size: A4;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 10px;
    }

    .invoice-page {
        page-break-after: always;
        padding: 20px;
    }

    .invoice-page:last-child {
        page-break-after: avoid;
    }

    #wrapper {
        width: 100%;
    }

    #content-wrapper {
        display: flex;
        flex-direction: column;
    }

    .card {
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 20px;
    }

    .card-body {
        padding: 20px;
    }

    .img-fluid {
        max-width: 90px;
        height: auto;
        margin-bottom: 20px;
    }

    .text-center {
        text-align: center;
    }

    .text-muted {
        color:rgb(7, 7, 7);
    }

    .badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }

    .badge-danger {
        color: #fff;
        background-color: #dc3545;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        margin-top: 10px;
    }

    .invoice-table th,
    .invoice-table td {
        border: 1px solid #dee2e6;
        padding: 8px;
    }

    .invoice-table th {
        background-color: #f8f9fa;
    }

    .h6 {
        font-size: 12px;
        font-weight: bold;
        margin: 0;
    }

    .h3 {
        font-size: 14px;
        font-weight: bold;
        margin: 0;
    }

    hr {
        margin: 10px 0;
        border: 0;
        border-top: 1px solid #dee2e6;
    }

    .px-0 {
        padding-left: 0;
        padding-right: 0;
    }

    .text-right {
        text-align: right;
    }

    .border-top {
        border-top: 1px solid #dee2e6;
    }

    .border-top-2 {
        border-top-width: 2px;
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
        }
        .card {
            box-shadow: none;
            border: none;
            margin: 0;
        }
        .invoice-page {
            height: 100vh;
            page-break-after: always;
        }
    }
</style>

<div class="invoice-page">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col text-center">
                                        <img class="img-fluid" alt="Logo" src="{{ asset(getMedia('logo')) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h5><b>Order Details :</b></h5>
                                  
                                        <span class="text-muted">Invoice Id :</span>{{ $order->invoice_number }}<br>
                                        <span class="text-muted">Order Date :</span>{{ $order->created_at->format('M d, Y') }}<br>
                                        <span class="text-muted">Payment Method :</span>Cash On Delivery<br>
                                    </div>
                                </div>
                                <table class="invoice-table">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <h4>Billing & Shipping Address :</h4>
                                                <hr>
                                                <span class="text-muted">Name: </span>{{$order->customer_info->name}}<br>
                                                <span class="text-muted">Phone: </span>{{$order->customer_info->phone}}<br>
                                                <span class="text-muted">Address: </span>{{$order->customer_address->address ?? null}}<br>
                                                <span class="text-muted">Billing Area: </span>{{$order->delivery}}<br>
                                                <span class="text-muted">Order Note: </span>{{$order->order_note}}<br>
                                                <span class="text-muted">Courier Note: </span>{{$order->courier_note}}<br>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="2">
                                                <div class="gd-responsive-table">
                                                    <table class="invoice-table">
                                                        <thead>
                                                            <tr>
                                                                <th width="50%" class="px-0 bg-transparent border-top-0">
                                                                    <span class="h6">Products</span>
                                                                </th>
                                                                <th class="px-0 bg-transparent border-top-0" width="10%">
                                                                    <span class="h6">SKU</span>
                                                                </th>
                                                                <th class="px-0 bg-transparent border-top-0">
                                                                    <span class="h6">Attribute</span>
                                                                </th>
                                                                <th class="px-0 bg-transparent border-top-0">
                                                                    <span class="h6">Quantity</span>
                                                                </th>
                                                                <th class="px-0 bg-transparent border-top-0 text-right">
                                                                    <span class="h6">Price</span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($order['items'] as $item)
                                                                <tr>
                                                                    <td class="px-0">
                                                                        {{$item['product_info']['product_name']}}
                                                                    </td>
                                                                    <td class="px-0" width="10%">
                                                                        {{$item['product_info']['product_code']}}
                                                                    </td>
                                                                    <td class="px-0">
                                                                        @foreach($item['option'] as $option)
                                                                            <span class="entry-meta">
                                                                                <b>{{$option['attributeOption']['attribute']['name']}} : 
                                                                                 {{$option['attributeOption']['name']}} </b> 
                                                                            </span>
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="px-0">
                                                                        {{$item['quantity']}}
                                                                    </td>
                                                                    <td class="px-0 text-right">
                                                                        Tk. {{$order->total_price}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td class="px-0 border-top border-top-2" colspan="4">
                                                                    <span class="text-muted">Shipping</span>
                                                                </td>
                                                                <td class="px-0 text-right border-top border-top-2">
                                                                    <span>Tk. {{$order->delivery_charge}}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="px-0 border-top border-top-2" colspan="4">
                                                                    <strong>Total amount</strong>
                                                                </td>
                                                                <td class="px-0 text-right border-top border-top-2">
                                                                    <span class="h3">Tk. {{number_format($order->total_price + $order->delivery_charge, 2)}}</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
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
@endforeach
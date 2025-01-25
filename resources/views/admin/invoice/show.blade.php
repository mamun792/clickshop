<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->invoice_number }} | {{siteInfo('app_name')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            padding: 20px;
        }

        .invoice-header {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .company-logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }

        .invoice-details {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .invoice-details th, .invoice-details td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        .invoice-details th {
            background-color: #f8f9fa;
        }

        .total-section {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        .invoice-footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
            border-radius: 8px;
            font-size: 10px;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .invoice-page {
                height: 100vh;
            }
        }
        .print-button {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 8px 16px;
    cursor: pointer;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 5px;
}

.print-button::before {
    content: '🖨️ Print';
}

.print-button:hover {
    background-color: #0056b3;
}

@media print {
    .print-button {
        display: none;
    }
}
    </style>
</head>
<body>

<div class="invoice-page">
         <div class="invoice-header">
            <img src="{{ asset(getMedia('logo')) }}" alt="{{siteInfo('app_name')}}" class="company-logo">
            <h2 style="font-size: 16px; margin: 10px 0;">Invoice</h2>
            <p>Invoice ID: {{ $invoice->invoice_number }} | Date: {{ $invoice->created_at->format('d M, Y') }}</p>
        </div>

        <button class="print-button" onclick="window.print()"></button>

    <div class="row">
        <div class="col-md-6">
            <h5><b>Billing Information</b></h5>
            <ul class="list-unstyled">
                <li><strong>Name:</strong> {{ $invoice->customer_name }}</li>
                <li><strong>Phone:</strong> {{ $invoice->phone_number ?? 'N/A' }}</li>
                <li><strong>Address:</strong> {{ $invoice->address ?? 'N/A' }}</li>
            </ul>
        </div>

        <div class="col-md-6">
            <h5><b>Shipping Information</b></h5>
            <ul class="list-unstyled">
                <li><strong>Delivery Type:</strong> {{ $invoice->delivery }}</li>
                <li><strong>Shipping Price:</strong> Tk. {{ $invoice->shipping_price ?? 'N/A' }}</li>
                <li><strong>Delivery Charge:</strong> Tk. {{ $invoice->delivery_charge }}</li>
            </ul>
        </div>
    </div>

    <h5 class="mt-4">Order Details</h5>
    <table class="invoice-details">
        <thead>
            <tr>
                <th>Product</th>
                <th>Attributes</th>
                <th>Quantity</th>
                <th>  Price</th>

                <th>Checkout Discount</th>

                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>
                        <img src="{{ $item->product->featured_image }}" alt="Product Image" class="product-image">
                        {{ $item->product->product_name }}
                    </td>
                    <td>
                        @if ($item->option->isEmpty())
                            <span>Attribute data not available</span>
                        @else
                            @foreach ($item->option as $option)
                                <span><b>{{ $option->attributeOption->attribute->name }}</b>: {{ $option->attributeOption->name }}</span><br>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>Tk. {{ $item->price }}</td>



                    <td>Tk. {{ $item->discount }} X {{$item->quantity}}</td>

                    <td>Tk. {{ (  $item->price * $item->quantity -($item->discount ?? 0))  }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <div class="total-section">
        <p>Shipping: Tk. {{ $invoice->delivery_charge }}</p>
        <p>Total Price: Tk. {{ $invoice->remaining_balance }}</p>


        <p style="font-size: 14px;">Grand Total: Tk. {{  $invoice->remaining_balance + $invoice->delivery_charge   }}</p>
    </div> --}}



    <div class="total-section">
        <p>Shipping: Tk. {{ $invoice->delivery_charge }}</p>
        <p>
            pos diccount : Tk. {{ $invoice->discount ?? 0 }}
        </p>
        <!-- <p>
            <span class="text-success fw-bold d-block">
                Partial Paid: Tk. {{ $invoice->paid_amount ?? 'N/A' }}
            </span>
        </p> -->


        <p style="font-size: 14px;">
            Grand Total: Tk. {{
                $invoice->items->sum(function($item) {
                    // Calculate the total for each item after applying its individual discount
                    return ($item->quantity * $item->price) - ($item->discount * $item->quantity);
                }) + $invoice->delivery_charge - $invoice->discount - $invoice->paid_amount
            }}
        </p>
    </div>



    <div class="invoice-footer">
        <p>&copy; {{ now()->year }} Your {{siteInfo('app_name')}}. All Rights Reserved.</p>
    </div>
</div>

 @include('admin.orders.dublicateordertable') 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- <script>
    window.onload = function () {
        window.print();
    };
</script> -->
</body>
</html>
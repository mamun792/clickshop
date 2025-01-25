<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="mt-3">
        <div class="mt-4 p-3">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; align-items:center; justify-content:space-between">
                        <img src="{{asset($media->logo)}}" width="70" height="70" />
                        <h6>Pathao Order Information</h6>
                        <p>Date : {{ now()->format('Y-m-d') }}</p>
                        <button class="btn btn-dark px-5" id="download-csv">Download CSV</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped" id="example">
                                    <thead>
                                        <tr>
                                            <th>ItemType</th>
                                            <th>StoreName</th>
                                            <th>MerchantOrderId</th>
                                            <th>RecipientName(*)</th>
                                            <th>RecipientPhone(*)</th>
                                            <th>RecipientCity(*)</th>
                                            <th>RecipientZone(*)</th>
                                            <th>RecipientArea</th>
                                            <th>RecipientAddress(*)</th>
                                            <th>ItemQuantity</th>
                                            <th>ItemWeight</th>
                                            <th>ItemDesc</th>
                                            <th>SpecialInstruction</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $index => $order)
                                            <tr>
                                                <td>parcel</td>
                                                <td><span>{{$order->pathao_store_name}}</span></td>
                                                <td><span>{{$order->invoice_number}}</span></td>
                                                <td><span>{{$order->customer_name}}</span></td>
                                                <td><span>{{$order->phone_number}}</span></td>
                                                <td><span>{{$order->city_name}}</span></td>
                                                <td><span>{{$order->zone_name}}</span></td>
                                                <td><span>{{$order->area_name}}</span></td>
                                                <td><span>{{$order->address}}</span></td>
                                                <td>
                                                    @foreach($order['items'] as $item)
                                                        {{$item['quantity']}}
                                                    @endforeach
                                                </td>
                                                <td>Below 1 kg</td>
                                                <td>None</td>
                                                <td>None</td>
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

    <script>
        // When the download button is clicked
        $('#download-csv').on('click', function() {
            var csvData = [];
            var rows = $('#example tbody tr');
            
            // Extract the table data
            rows.each(function() {
                var rowData = [];
                $(this).find('td').each(function() {
                    rowData.push($(this).text().trim());
                });
                csvData.push(rowData.join(','));
            });

            // Create a CSV string
            var csvFile = csvData.join('\n');

            // Create a Blob with the CSV data
            var blob = new Blob([csvFile], { type: 'text/csv' });

            // Create a link to download the file
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'orders.csv';  // Name of the file
            link.click();
        });
    </script>

</body>

</html>

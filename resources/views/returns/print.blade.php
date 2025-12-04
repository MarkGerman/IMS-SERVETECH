<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Return</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #fff;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .items-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Return Details</h1>
        </div>
        @if (!empty($return))
            <div class="details">
                <p><strong>Return ID:</strong> {{ $return->id }}</p>
                <p><strong>Sale ID:</strong> {{ $return->sale_id }}</p>
                <p><strong>Customer:</strong> {{ $return->customer->name ?? 'N/A' }}</p>
                <p><strong>Return Date:</strong> {{ $return->return_date->format('Y-m-d') }}</p>
                <p><strong>Total Refund Amount:</strong> MWK{{ number_format($return->total_refund_amount, 2) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($return->status) }}</p>
                <p><strong>Reason:</strong> {{ $return->reason }}</p>
                <p><strong>Created By:</strong> {{ $return->creator->name ?? 'N/A' }}</p>
                <p><strong>Approved By:</strong> {{ $return->approver->name ?? 'N/A' }}</p>
            </div>

            <h5 class="mt-4">Returned Items</h5>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (empty($return->returnItems) ? [] : $return->returnItems as $item)
                        <tr>
                            <td>{{ $item->saleItem->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>MWK{{ number_format($item->saleItem->unit_price, 2) }}</td>
                            <td>MWK{{ number_format($item->quantity * $item->saleItem->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>

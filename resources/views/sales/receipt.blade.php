<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $sale->id }}</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .receipt { width: 500px; margin: auto; border: 1px solid #ddd; padding: 15px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 4px; border-bottom: 1px solid #ccc; }
        .total { font-weight: bold; }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt">
        <h2>Tea POS Receipt</h2>
        <p><strong>Receipt ID:</strong> {{ $sale->id }}</p>
        <p><strong>Date:</strong> {{ $sale->created_at->format('Y-m-d H:i:s') }}</p>

        @if($sale->customer)
            <p><strong>Customer:</strong> {{ $sale->customer->name }}</p>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Tea</th>
                    <th>Qty (g)</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                    <tr>
                        <td>{{ $item->tea->tea_grade }}</td>
                        <td>{{ number_format($item->quantity, 2) }}</td>
                        <td>{{ number_format($item->tea->selling_price * $item->quantity, 2) }} LKR</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Sub Total: {{ number_format($sale->total_cost + $sale->discount, 2) }} LKR</p>
        <p class="total">Discount: {{ number_format($sale->discount, 2) }} LKR</p>
        <p class="total">Total: {{ number_format($sale->total_cost, 2) }} LKR</p>
        <p class="total">Cash: {{ number_format($sale->cash, 2) }} LKR</p>
        <p class="total">Balance: {{ number_format($sale->cash - $sale->total_cost, 2) }} LKR</p>

        <p style="text-align: center;">Thank you!</p>
    </div>
</body>
</html>

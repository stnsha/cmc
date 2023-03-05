<!DOCTYPE html>
<html>

<head>
    <title>Receipt for CMC Buffet Ramadhan 2023</title>
    <style>
        table,
        td,
        th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 15px;
        }
    </style>
</head>

<body>
    <h1>Customer receipt</h1>
    <p>We have successfully received your booking. See you soon!</p>
    <table>
        <tr>
            <th>Customer name</th>
            <td colspan="3">{{ $mailData['order']['customer_name'] }}</td>
        </tr>
        <tr>
            <th>Phone no.</th>
            <td colspan="3">{{ $mailData['order']['customer_phone'] }}</td>
        </tr>
        <tr>
            <th>Venue</th>
            <td colspan="3">{{ $mailData['venue'] }}</td>
        </tr>
        <tr>
            <th>Date & time</th>
            <td colspan="3">{{ $mailData['venue_date'] }}, 6.30 P.M.</td>
        </tr>
        <tr>
            <th>Customer type</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <tr>
            @foreach ($mailData['order']->order_details as $item)
            <td>
                {{ $item->pricing->type }}
            </td>
            <td>
                RM {{ number_format($item->price, 2) }}
            </td>
            <td>
                {{ $item->quantity }}
            </td>
            <td>
                RM {{ number_format($item->subtotal, 2) }}
            </td>
            @endforeach
        </tr>
        <tr>
            <th>Subtotal</th>
            <td colspan="3">RM {{ number_format((float)$mailData['order']['subtotal'], 2, '.', '')}}</td>
        </tr>
        <tr>
            <th>Service charge</th>
            <td colspan="3">RM {{ number_format((float)$mailData['order']['service_charge'], 2, '.', '')}}</td>
        </tr>
        <tr>
            <th>Total</th>
            <td colspan="3">RM {{ number_format((float)$mailData['order']['total'], 2, '.', '')}}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td colspan="3">{{ $mailData['order']['status'] }}</td>
        </tr>
    </table>
</body>

</html>
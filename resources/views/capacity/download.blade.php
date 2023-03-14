<html>
<table>
    <thead>
        <tr>
            <th>Venue</th>
            <th>Date</th>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone no.</th>
            <th>Adults</th>
            <th>Warga emas/Kanak-kanak</th>
            <th>Kanak-kanak (Free)</th>
            <th>Kanak-kanak (RM10)</th>
            <th>Group</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $item)
        <tr>
            <td>{{ $item['venue_location'] }}</td>
            <td>{{ $item['venue_date'] }}</td>
            <td>{{ $item['order_id'] }}</td>
            <td>{{ $item['customer_name'] }}</td>
            <td>{{ $item['customer_email'] }}</td>
            <td>{{ $item['customer_phone'] }}</td>
            <td>{{ $item['adults'] }}</td>
            <td>{{ $item['elderly_kids'] }}</td>
            <td>{{ $item['kid_free'] }}</td>
            <td>{{ $item['kid_pay'] }}</td>
            <td>{{ $item['group'] }}</td>
            <td>{{ $item['total'] }}</td>
            <td>{{ $item['status'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</html>
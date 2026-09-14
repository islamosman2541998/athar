<!DOCTYPE html>
<html>
<head>
    <title>Order Shipping status  </title>
</head>
<body>
<h3> Hi {{$order->customer_name}}</h3>

<p>We want to inform you that You order Has been changed recently </p>
<ul>
    <li>Order ID: {{ $order->id }}</li>

    <li>Shipping Status: {{ $order->shipped_status }}</li>
    <!-- Add more order details as needed -->
</ul>
</body>
</html>

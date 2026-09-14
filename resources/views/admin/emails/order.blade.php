<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
<h1>Order Confirmation</h1>
<p>Thank you for your order!</p>
<p>Order Details:</p>
<ul>
    <li>Order ID: {{ $order->id }}</li>
    <li>Total: {{ $order->total }}</li>
    <li>Status: {{ $order->status }}</li>
    <li>Shipping Status: {{ $order->shipped_status }}</li>

    <!-- Add more order details as needed -->
</ul>
</body>
</html>

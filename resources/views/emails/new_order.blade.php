<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>

<body>

    <div>
        <h1>مرحبا بك في Dalia Elhagar</h1>
        <p>لقد تم إنشاء طلب جديد بنجاح.</p>

        <h2>طلب جديد!</h2>
        <p>رقم الطلب: {{ $order->id }}</p>
        <p>تاريخ الطلب: {{ $order->created_at }}</p>
        <p> {{ $order->customer_name }}: العميل </p>
        <p> {{ $order->address }} : العنوان</p>
        @if ($order->customer_email)
            <p>البريد: {{ $order->customer_email }}</p>
        @endif

        @if ($order->extraOrderDetails->same_day == 1)
            <p><strong>موعد التوصيل </strong> التوصيل في نفس اليوم.</p>
        @elseif($order->extraOrderDetails->delivery_date)
            <p> {{ $order->extraOrderDetails->delivery_date->translatedFormat('d F Y') }}
                {{ $order->extraOrderDetails->specific_time }} <strong>موعد التوصيل </strong>
            </p>
        @endif

        <p>الهاتف: {{ $order->customer_mobile }}</p>
        <p>{{ $order->paymentMethod->title }} : طريقة الدفع </p>
        <p> : صورة التحويل
            @if ($order->image)
                <img src="{{ url($order->image) }}" alt="image">
            @endif

        </p>


        <p>المبلغ : {{ number_format($order->orderDetails->sum('total'), 2) }} </p>
        @if ($order->discount)
            <p>الخصم : {{ $order->discount }}</p>
        @endif
        <p>الشحن : {{ $order->shipped_price }}</p>

        <p>المبلغ الإجمالي: {{ $order->total }}</p>

        <hr>
        <h5 class="mb-3">{{ __('orders.items_ordered') }}</h5>
        <ul class="list-unstyled mb-0">
            @foreach ($order->orderDetails as $detail)
                <li class="d-flex justify-content-between align-items-center">

                    <span>{{ $detail->product->name ?? $detail->product_name }} ×{{ $detail->quantity }}</span>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <span class=" mb-2"><img class=" img_order rounded-circle text-center"
                                src="{{ url($detail->product->pathInView()) }}" alt=""></span>
                        <span>{{ number_format($detail->price_after_sale ?? $detail->price, 2) }} EGP</span>
                    </div>

                </li>
            @endforeach
        </ul>

        <p class="signature">Dalia Elhagar</p>

        Regards,
        Athar
    </div>
</body>

</html>

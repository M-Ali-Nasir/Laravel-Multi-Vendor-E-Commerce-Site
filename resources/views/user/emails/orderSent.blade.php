Hey {{ $customer->name }}, your order {{ $product->name }} of ammount
{{ $order->amount }} is on the way to your given address.
<b>
    ORDER DETAILS:
    <b>
        NAME: {{ $product->name }}<b>
            Payment Method: {{ $order->payment_method }}<b>
                Quantity: {{ $order->quantity }}<b>

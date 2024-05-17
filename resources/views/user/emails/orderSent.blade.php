Hey {{ $customer->name }}, your order {{ $product->name }} of ammount
{{ $order->amount }} is on the way to your given address.
<br>
<b>ORDER DETAILS:</b>
<br>
NAME: {{ $product->name }}<br>
Payment Method: {{ $order->payment_method }}<br>
Quantity: {{ $order->quantity }}<br>

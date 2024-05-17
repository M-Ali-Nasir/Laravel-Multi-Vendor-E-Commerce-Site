Hey {{ $customer->name }}, your order is done of ammount {{ $newOrder->amount }}.
<br>
<b>ORDER DETAILS:</b>
<br>
NAME: {{ $product->name }}<br>
Payment Method: {{ $newOrder->payment_method }}<br>
Quantity: {{ $newOrder->quantity }}<br>

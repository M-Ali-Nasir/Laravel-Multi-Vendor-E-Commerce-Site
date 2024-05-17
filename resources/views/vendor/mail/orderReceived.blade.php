Hey {{ $vendor->name }}, you recieved an order from {{ $customer->name }} of ammount {{ $newOrder->amount }}.
<b>
    ORDER DETAILS:
    <b>
        NAME: {{ $product->name }}<b>
            Payment Method: {{ $newOrder->payment_method }}<b>
                Quantity: {{ $newOrder->quantity }}<b>

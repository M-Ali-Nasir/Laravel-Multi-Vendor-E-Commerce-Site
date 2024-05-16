@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Dashboard')

@section('mainBody')
    @php
        $selectedVariation = [];
        if (isset($product['variations'])) {
            foreach ($product['variations'] as $var) {
                if ($var['id'] == $variation->id) {
                    $selectedVariation = $var['pivot'];
                    break;
                }
            }
        } else {
            $selectedVariation = ['name' => 'Not Found', 'price_modifier' => 0];
        }
    @endphp

    <div class="container" id="printable-content">
        <h2>Order Details</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order # {{ $order->id }}</h5>
                        <p class="card-text">Order Date: {{ $order->created_at }}</p>
                        <p class="card-text">Store Name: {{ $store->name }}</p>
                        <p class="card-text">Customer Name: {{ $customer->name }}</p>
                        <p class="card-text">Customer Email: {{ $customer->email }}</p>
                        <p class="card-text">Total Amount: {{ $order->amount }} pkr</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price/item</th>
                                <th>Variation</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price + $selectedVariation['price_modifier'] }}</td>
                                <td>{{ $variation->name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->quantity * ($product->price + $selectedVariation['price_modifier']) }}</td>
                            </tr>

                            <!-- Add more rows for other products -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Shipping Details</h5>
                        <p class="card-text">Name: {{ $customer->name }}</p>
                        <p class="card-text">Phone no: {{ $orderAddress->shipping_phone }}</p>
                        <p class="card-text">Address: {{ $orderAddress->shipping_address }}</p>
                        <p class="card-text"> State: {{ $orderAddress->shipping_state }} &nbsp;/ &nbsp;Zip Code:
                            {{ $orderAddress->shipping_zip }}</p>
                        <p class="card-text">Country: {{ $orderAddress->shipping_country }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if (!($order->payment_method == 'Card'))
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Billing Details</h5>
                            <p class="card-text">Name: {{ $customer->name }}</p>
                            <p class="card-text">Phone no: {{ $orderAddress->billing_phone }}</p>
                            <p class="card-text">Address: {{ $orderAddress->billing_address }}</p>
                            <p class="card-text"> State: {{ $orderAddress->billing_state }} &nbsp;/ &nbsp;Zip Code:
                                {{ $orderAddress->billing_zip }}</p>
                            <p class="card-text">Country: {{ $orderAddress->billing_country }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payment Details</h5>
                        <p class="card-text">Payment Method: {{ $order->payment_method }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($orderHistory->status == 'Pending')
        <a class="btn btn-outline-primary mt-4 mb-5 ms-3 float-right"
            href="{{ route('fullfillOrder', ['id' => $vendor->id, 'order_id' => $order->id]) }}">Fullfill Order</a>
    @endif
    <button class="btn btn-outline-primary mt-4 mb-5 ms-3 float-right" onclick="printContent()">Print Reciept</button>

    <script>
        function printContent() {
            var content = document.getElementById('printable-content');
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = content.innerHTML;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>



@endsection

@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Dashboard')

@section('mainBody')

    <div class="container">
        <h2>Order Details</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order #12345</h5>
                        <p class="card-text">Order Date: January 1, 2024</p>
                        <p class="card-text">Customer Name: John Doe</p>
                        <p class="card-text">Customer Email: john@example.com</p>
                        <p class="card-text">Total Amount: $100.00</p>
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
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Product 1</td>
                                <td>$20.00</td>
                                <td>2</td>
                                <td>$40.00</td>
                            </tr>
                            <tr>
                                <td>Product 2</td>
                                <td>$30.00</td>
                                <td>1</td>
                                <td>$30.00</td>
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
                        <h5 class="card-title">Shipping Address</h5>
                        <p class="card-text">John Doe</p>
                        <p class="card-text">123 Main St</p>
                        <p class="card-text">City, State, Zip Code</p>
                        <p class="card-text">Country</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payment Details</h5>
                        <p class="card-text">Payment Method: Credit Card</p>
                        <p class="card-text">Transaction ID: 123456789</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

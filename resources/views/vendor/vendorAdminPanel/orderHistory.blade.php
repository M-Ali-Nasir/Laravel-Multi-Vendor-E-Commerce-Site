@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Dashboard')

@section('mainBody')

    <div class="container mt-4">
        <h2 class="mb-4">Completed Orders</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Order Date</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                @php
                                    $customer = $customers->firstWhere('id', $order->customer_id);
                                @endphp

                                {{ $customer->name }}


                            </td>

                            <td>{{ $order->amount }}</td>
                            <td>Completed</td>
                            <td><a href="{{ route('singleOrderDetails', ['id' => $vendor->id, 'order_id' => $order->id]) }}"
                                    class="btn btn-primary">Reciept</a>
                            </td>
                        </tr>
                    @endforeach


                    <!-- Add more rows for other orders -->
                </tbody>
            </table>
        </div>
    </div>

@endsection

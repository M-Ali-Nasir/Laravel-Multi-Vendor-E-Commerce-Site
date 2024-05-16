@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Dashboard')

@section('mainBody')

    <div class="container">
        <h2>All Payments</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Payment Date/Time</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->id }}</td>
                            <td>
                                @foreach ($customers as $customer)
                                    @if ($customer->id == $order->customer_id)
                                        {{ $customer->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $order->amount }}</td>
                            <td>
                                @foreach ($orderHistories as $status)
                                    @if ($status->order_id == $order->id)
                                        {{ $status->updated_at }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $order->payment_method }}</td>
                            <td>
                                @foreach ($orderHistories as $status)
                                    @if ($status->order_id == $order->id)
                                        {{ $status->status }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach

                    <!-- Add more rows for other payments -->
                </tbody>
            </table>
        </div>
    </div>

@endsection

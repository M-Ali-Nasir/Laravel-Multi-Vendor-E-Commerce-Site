@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Dashboard')



@section('mainBody')





    <div class="container mt-4">
        <h2 class="mb-4">Completed Orders</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Shipped Orders: </th>
                        <th>{{ $shippedOrders }}</th>
                        <th>Dlivered Orders: </th>
                        <th>{{ $deliveredOrders }}</th>
                        <th>Returned Orders: </th>
                        <th>{{ $returnedOrders }}</th>
                    </tr>
                </tbody>
            </table>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Order #</th>
                        <th class="text-center">Order Date</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Total Amount</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="text-center">{{ $order->id }}</td>
                            <td class="text-center">{{ $order->created_at }}</td>
                            <td class="text-center">
                                @php
                                    $customer = $customers->firstWhere('id', $order->customer_id);
                                @endphp

                                {{ $customer->name }}


                            </td>

                            <td class="text-center">{{ $order->amount }}</td>
                            <td class="text-center">
                                @foreach ($orderHistory as $history)
                                    @if ($history->order_id == $order->id)
                                        @if ($history->status == 'Completed')
                                            Order Sent
                                        @else
                                            {{ $history->status }}
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                            <td class="text-center"><a
                                    href="{{ route('singleOrderDetails', ['id' => $vendor->id, 'order_id' => $order->id]) }}"
                                    class="btn btn-primary">Reciept</a>
                                @foreach ($orderHistory as $history)
                                    @if ($history->order_id == $order->id)
                                        @if ($history->status == 'Completed')
                                            <a href="{{ route('deliverdOrder', ['id' => $vendor->id, 'order_id' => $order->id]) }}"
                                                class="btn btn-primary" onclick="alert()">Delivered</a>
                                        @endif
                                        @if ($history->status == 'Delivered' && $history->status != 'Returned')
                                            <a href="{{ route('returnedOrder', ['id' => $vendor->id, 'order_id' => $order->id]) }}"
                                                class="btn btn-warning" onclick="alert()">Returned</a>
                                        @endif
                                    @endif
                                @endforeach


                            </td>
                        </tr>
                    @endforeach


                    <!-- Add more rows for other orders -->
                </tbody>
            </table>
        </div>
    </div>


@endsection

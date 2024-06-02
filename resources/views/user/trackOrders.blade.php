@extends('user.userHome')

@section('title', 'Track Order')

@section('style')

    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #ffffff;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to top left, rgb(255, 255, 255), rgba(246, 243, 255, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to top left, rgb(255, 255, 255), rgba(246, 243, 255, 1))
        }
    </style>

@endsection

@section('body')



    <section class="h-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-10 col-xl-8">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-header px-4 py-5">
                            <h5>Order Tracking</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">

                            </div>

                            @if (isset($orders))
                                @foreach ($orders as $order)
                                    <div class="card shadow-0 border mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <p>{{ $order->id }}</p>
                                                </div>

                                                <div class="col-md-2">
                                                    <img src="{{ asset('storage/vendor/products/images/' . $order->product->image) }}"
                                                        class="img-fluid" alt="Phone">
                                                </div>
                                                <table class="table striped-table m-3" style="width: 70%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Variation</th>
                                                            <th class="text-center">Quantity</th>
                                                            <th class="text-center">Price</th>
                                                            <th class="text-center">Ordered at</th>
                                                        </tr>

                                                    </thead>
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="">
                                                                <p class="text-muted mb-0">{{ $order->product->name }}</p>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="">
                                                                <p class="text-muted mb-0 small">
                                                                    {{ $order->variation->name }}</p>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="">
                                                                <p class="text-muted mb-0 small">{{ $order->quantity }}
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="">
                                                                <p class="text-muted mb-0 small">Rs.{{ $order->amount }}/-
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="">
                                                                <p class="text-muted mb-0 small">
                                                                    {{ $order->created_at->format('d/m/Y') }}</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {{-- <div
                                                        class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                        <p class="text-muted mb-0">{{ $order->product->name }}</p>
                                                    </div>
                                                    <div
                                                        class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                        <p class="text-muted mb-0 small">{{ $order->variation->name }}</p>
                                                    </div>
                                                    <div
                                                        class="col-md-1 text-center d-flex justify-content-center align-items-center">
                                                        <p class="text-muted mb-0 small">Qty: {{ $order->quantity }}</p>
                                                    </div>
                                                    <div
                                                        class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                        <p class="text-muted mb-0 small">Rs.{{ $order->amount }}/-</p>
                                                    </div>
                                                    <div
                                                        class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                        <p class="text-muted mb-0 small">
                                                            {{ $order->created_at->format('d/m/Y') }}</p>
                                                    </div> --}}
                                                </table>
                                            </div>
                                            <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                            <div class="row d-flex align-items-center">
                                                {{-- <div class="col-md-2">
                                                <p class="text-muted mb-0 small">Track Order</p>
                                            </div> --}}
                                                <div class="col-md-12">
                                                    <div class="progress" style="height: 6px; border-radius: 16px;">
                                                        @if ($order->orderHistory[0]->status == 'Pending')
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 1%; border-radius: 16px; background-color: #ff4949;"
                                                                aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        @elseif ($order->orderHistory[0]->status == 'Completed')
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 50%; border-radius: 16px; background-color: #ffb649;"
                                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        @elseif ($order->orderHistory[0]->status == 'Delivered')
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 100%; border-radius: 16px; background-color: #21a850;"
                                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        @elseif ($order->orderHistory[0]->status == 'Returned')
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 100%; border-radius: 16px; background-color: #d31212;"
                                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        @endif

                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1 " style="">
                                                        @if ($order->orderHistory[0]->status == 'Returned')
                                                            <p class="text-muted text-danger mt-1 mb-0 small ">Order
                                                                Returned</p>
                                                        @else
                                                            <p class="text-muted mt-1 mb-0 small ">Processed</p>
                                                            <p class="text-muted mt-1 mb-0 small ">Out for delivary</p>
                                                            <p class="text-muted mt-1 mb-0 small ">Delivered</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Nothing To Track</p>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

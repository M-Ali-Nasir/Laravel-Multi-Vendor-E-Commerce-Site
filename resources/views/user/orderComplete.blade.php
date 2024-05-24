@extends('user.userHome')

@section('title', 'Order Completed')

@section('style')

    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #ffffff;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to top left, rgb(255, 255, 255), rgb(255, 255, 255));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to top left, rgb(255, 255, 255), rgb(255, 255, 255))
        }
    </style>

@endsection

@section('body')

    @php
        $orderItems = Session::get('cartItems');
        $totalPrice = 0;
        $shippingFee = 0;
        $tax = 0;

    @endphp


    <section class="h-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-10 col-xl-8">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-header px-4 py-5">
                            <h5 class="text-muted mb-0 text-dark">Thanks for your Order, <span>{{ $customer->name }}</span>!
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <p class="lead fw-normal mb-0 text-dark">Receipt</p>
                                {{-- <p class="small text-muted mb-0">Order Id : 1KAU9-84UIL</p> --}}
                            </div>
                            @if (isset($orderItems))

                                @foreach ($orderItems as $item)
                                    <div class="card shadow-0 border mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    @foreach ($products as $product)
                                                        @if ($product->id == $item->product_id)
                                                            <img src="{{ asset('storage/vendor/products/images/' . $product->image) }}"
                                                                class="img-fluid" alt="Phone">
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div
                                                    class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                    <p class="text-muted mb-0">
                                                        @foreach ($products as $product)
                                                            @if ($product->id == $item->product_id)
                                                                {{ $product->name }}
                                                            @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                                <div
                                                    class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                    <p class="text-muted mb-0 small">
                                                        @foreach ($variations as $variation)
                                                            @if ($variation->id == $item->variation_id)
                                                                {{ $variation->name }}
                                                            @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                                {{-- <div
                                                class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">Capacity: 64GB</p>
                                            </div> --}}
                                                <div
                                                    class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                    <p class="text-muted mb-0 small">Qty: {{ $item->quantity }}</p>
                                                </div>
                                                <div
                                                    class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                    <p class="text-muted mb-0 small">{{ $item->quantity * $item->price }}
                                                    </p>
                                                </div>
                                            </div>
                                            {{-- <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-md-2">
                                                <p class="text-muted mb-0 small">Track Order</p>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="progress" style="height: 6px; border-radius: 16px;">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: 65%; border-radius: 16px; background-color: #a8729a;"
                                                        aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="d-flex justify-content-around mb-1">
                                                    <p class="text-muted mt-1 mb-0 small ms-xl-5">Out for delivary</p>
                                                    <p class="text-muted mt-1 mb-0 small ms-xl-5">Delivered</p>
                                                </div>
                                            </div>
                                        </div> --}}
                                        </div>
                                    </div>
                                    @php
                                        $totalPrice += $item->price * $item->quantity;
                                        $shippingFee += 150 * $item->quantity;

                                    @endphp
                                @endforeach
                            @endif


                            <div class="d-flex justify-content-between pt-2">
                                <p class="fw-bold mb-0">Order Details</p>
                                <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span> {{ $totalPrice }}</p>
                            </div>

                            {{-- <div class="d-flex justify-content-between pt-2">
                                <p class="text-muted mb-0">Invoice Number : 788152</p>
                                <p class="text-muted mb-0"><span class="fw-bold me-4">Discount</span> $19.00</p>
                            </div> --}}

                            <div class="d-flex justify-content-between">
                                <p class="text-muted mb-0">Invoice Date : {{ now()->toDateString() }}</p>
                                <p class="text-muted mb-0"><span class="fw-bold me-4">GST</span> {{ $tax }}</p>
                            </div>

                            <div class="d-flex justify-content-between mb-5">
                                {{-- <p class="text-muted mb-0">Recepits Voucher : 18KU-62IIK</p> --}}
                                <p class="text-muted mb-0"><span class="fw-bold me-4">Delivery Charges</span>
                                    {{ $shippingFee }}</p>
                            </div>
                        </div>
                        <div class="card-footer border-0 px-4 py-5 bg-dark"
                            style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                            <h6 class="d-flex align-items-center justify-content-end text-light text-uppercase mb-0">Total
                                paid: <span class="h6 mb-0 ms-2">{{ $totalPrice + $tax + $shippingFee }}</span></h6>

                            <a class="btn btn-secondary" href="{{ route('home') }}">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





@endsection

@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Dashboard')


@section('style')
    <style>
        .div {

            display: flex;
            max-width: 300px;
            gap: 20px;
            color: #fff;
            font-weight: 400;
            justify-content: space-between;
        }

        .div-2 {
            background-color: #01254f;
            width: 11px;
            height: 150px;
        }

        .div-3 {
            font-family: Inter, sans-serif;
            align-self: start;
            margin: 16px 0 0 -1px;
            text-align: start;
        }

        .div-4 {
            display: flex;
            gap: 8px;
            font-size: 20px;
            padding: 20px 20px;
        }

        .div-5 {
            align-self: end;
            margin: 99px 10px 10px 30px;
            font: 36px Inter, sans-serif;
        }
    </style>
@endsection

@section('mainBody')


    <div class="p-4">
        <h3>Welcome {{ $vendor->name }} to your Dashboard</h3>
        <!-- Add your main content here -->
    </div>

    {{-- Order Details --}}

    <div class="mt-5">
        <h4>Orders Detail:</h4>
    </div>

    <div class="container mt-4">


        <div class="row justify-content-center">
            <div class="col-md-4 mb-1">
                <div class="card text-center border-0">
                    <div class="card-body p-0">
                        <div class="div" style="background-color: #0d82a7">
                            <div class="div-2"></div>
                            <div class="div-3">Total Orders</div>
                            <div class="div-4"></div>
                            <div class="div-5">{{ $totalOrders }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-1">
                <div class="card text-center border-0">
                    <div class="card-body p-0">
                        <div class="div" style="background-color: #0da771">
                            <div class="div-2"></div>
                            <div class="div-3">Completed Orders</div>
                            <div class="div-4"></div>
                            <div class="div-5">{{ $completedOrders }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-1">
                <div class="card text-center border-0">
                    <div class="card-body p-0">
                        <div class="div" style="background-color: #a75d0d">
                            <div class="div-2"></div>
                            <div class="div-3">Pending Orders</div>
                            <div class="div-4"></div>
                            <div class="div-5">{{ $pendingOrders }}</div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


    {{-- Revenue Details --}}

    <div class="mt-5">
        <h4>Revenue Detail:</h4>
    </div>

    <div class="container mt-4">


        <div class="row justify-content-center">
            <div class="col-md-4 mb-1">
                <div class="card text-center border-0">
                    <div class="card-body p-0">
                        <div class="div" style="background-color: #a70d64">
                            <div class="div-2"></div>
                            <div class="div-3">Total Earned</div>
                            <div class="div-4"></div>
                            <div class="div-5">{{ $totalEarned }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-1">
                <div class="card text-center border-0">
                    <div class="card-body p-0">
                        <div class="div" style="background-color: #310da7">
                            <div class="div-2"></div>
                            <div class="div-3">Received Payments</div>
                            <div class="div-4"></div>
                            <div class="div-5">{{ $recievedPayment }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-1">
                <div class="card text-center border-0">
                    <div class="card-body p-0">
                        <div class="div" style="background-color: #0d5fa7">
                            <div class="div-2"></div>
                            <div class="div-3">Total Customers</div>
                            <div class="div-4"></div>
                            <div class="div-5">{{ $totalCustomers }}</div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>



@endsection

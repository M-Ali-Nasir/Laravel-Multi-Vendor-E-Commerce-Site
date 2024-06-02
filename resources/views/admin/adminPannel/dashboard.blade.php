@extends('admin.adminPannel.layout.layout')

@section('title', 'Dashboard')

@section('mainBody')

    <div class="container">
        <div class="mt-5">
            <h4>User Details:</h4>
        </div>

        <div class="container mt-4">


            <div class="row justify-content-center">
                <div class="col-md-6 mb-">
                    <div class="card text-center border-0">
                        <div class="card-body p-5">
                            <div class="div rounded-3 p-5 shadow-lg" style="background-color: #0d82a7">
                                <div class="div-2"></div>
                                <div class="text-light">
                                    <h3>Total Customers</h3>
                                </div>
                                <div class="div-4"></div>
                                <div class="text-light">
                                    <h5>{{ count($customers) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-">
                    <div class="card text-center border-0">
                        <div class="card-body p-5">
                            <div class="div rounded-3 p-5 shadow-lg" style="background-color: #0d82a7">
                                <div class="div-2"></div>
                                <div class="text-light">
                                    <h3>Total Vendors</h3>
                                </div>
                                <div class="div-4"></div>
                                <div class="text-light">
                                    <h5>{{ count($vendors) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>



@endsection

@extends('user.userHome')

@section('title', 'My Account')

@section('style')
    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }

        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
        }






        .card {
            margin-bottom: 24px;
            -webkit-box-shadow: 0 2px 3px #e4e8f0;
            box-shadow: 0 2px 3px #e4e8f0;
            height: 300px;
            overflow-y: scroll;
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #eff0f2;
            border-radius: 1rem;
        }

        .activity-checkout {
            list-style: none
        }

        .activity-checkout .checkout-icon {
            position: absolute;
            top: -4px;
            left: -24px
        }

        .activity-checkout .checkout-item {
            position: relative;
            padding-bottom: 24px;
            padding-left: 35px;
            border-left: 2px solid #f5f6f8
        }

        .activity-checkout .checkout-item:first-child {
            border-color: #3b76e1
        }

        .activity-checkout .checkout-item:first-child:after {
            background-color: #3b76e1
        }

        .activity-checkout .checkout-item:last-child {
            border-color: transparent
        }

        .activity-checkout .checkout-item.crypto-activity {
            margin-left: 50px
        }

        .activity-checkout .checkout-item .crypto-date {
            position: absolute;
            top: 3px;
            left: -65px
        }



        .avatar-xs {
            height: 1rem;
            width: 1rem
        }

        .avatar-sm {
            height: 2rem;
            width: 2rem
        }

        .avatar {
            height: 3rem;
            width: 3rem
        }

        .avatar-md {
            height: 4rem;
            width: 4rem
        }

        .avatar-lg {
            height: 5rem;
            width: 5rem
        }

        .avatar-xl {
            height: 6rem;
            width: 6rem
        }

        .avatar-title {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: #3b76e1;
            color: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            font-weight: 500;
            height: 100%;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 100%
        }

        .avatar-group {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 8px
        }

        .avatar-group .avatar-group-item {
            margin-left: -8px;
            border: 2px solid #fff;
            border-radius: 50%;
            -webkit-transition: all .2s;
            transition: all .2s
        }

        .avatar-group .avatar-group-item:hover {
            position: relative;
            -webkit-transform: translateY(-2px);
            transform: translateY(-2px)
        }

        .card-radio {
            background-color: #fff;
            border: 2px solid #eff0f2;
            border-radius: .75rem;
            padding: .5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block
        }

        .card-radio:hover {
            cursor: pointer
        }

        .card-radio-label {
            display: block
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px
        }

        .card-radio-input {
            display: none
        }

        .card-radio-input:checked+.card-radio {
            border-color: #3b76e1 !important
        }


        .font-size-16 {
            font-size: 16px !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        a {
            text-decoration: none !important;
        }


        .form-control {
            display: block;
            width: 100%;
            padding: 0.47rem 0.75rem;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #545965;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e2e5e8;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.75rem;
            -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px;
        }

        .ribbon {
            position: absolute;
            right: -26px;
            top: 20px;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            padding: 1px 22px;
            font-size: 13px;
            font-weight: 500
        }
    </style>

@endsection

@section('body')

    <section class="py-3">
        {{-- <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card profile-card">
                        <img src="{{ asset($customer->profile_picture ? 'images/customers/' . $customer->profile_picture : 'images/default/user.png') }}"
                            alt="Profile Picture" class="card-img-top profile-pic">
                        <div class="card-body">
                            <h2 class="card-title profile-heading">{{ $customer->name }}</h2>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="bi bi-envelope me-2"></i>{{ $customer->email }}</li>
                                <li class="list-group-item"><i class="bi bi-phone me-2"></i>{{ $customer->phone }}</li>
                                <li class="list-group-item"><i class="bi bi-geo me-2"></i>{{ $customer->address }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}





        <div class="container rounded bg-white  mb-5">
            <form action="{{ route('updateCustomerProfile', ['id', $customer->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">


                    <div class="col-md-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                                class="rounded-circle mt-5" width="150px"
                                src="{{ asset($customer->avatar ? 'Storage/customer/avatars/' . $customer->avatar : 'images/default/user.png') }}"><span
                                class="font-weight-bold">{{ $customer->name }}</span><span
                                class="text-black-50">{{ $customer->email }}</span><span>
                                <input class="form-control mt-3" type="file" placeholder="Select New Image"
                                    name="avatar">
                            </span></div>
                    </div>
                    <div class="col-md-5 border-right">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profile Settings</h4>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12"><label class="labels">Name</label><input type="text"
                                        class="form-control" placeholder="Name" value="{{ $customer->name }}"
                                        name="name">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text"
                                        class="form-control" placeholder="enter phone number" value="{{ $customer->phone }}"
                                        name="phone">
                                </div>

                                <div class="col-md-12"><label class="labels">Email ID</label><input type="text"
                                        class="form-control" placeholder="enter email id" value="{{ $customer->email }}"
                                        disabled></div>

                                <div class="col-md-12"><label class="labels">Address:</label><input type="text"
                                        class="form-control" placeholder="enter address" value="{{ $customer->address }}"
                                        name="address"></div>

                                <div class="col-md-12"><label class="labels">Shipping Address:</label><input type="text"
                                        class="form-control" placeholder="enter address"
                                        value="{{ $customer->shipping_address }}" disabled></div>
                                <div class="col-md-12"><label class="labels">Billing Address:</label><input type="text"
                                        class="form-control" placeholder="enter address"
                                        value="{{ $customer->billing_address }}" disabled></div>


                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Bio:</label>
                                    <textarea type="text" class="form-control" placeholder="Write about yourself!" name="bio">{{ $customer->bio }}</textarea>
                                </div>
                            </div>
                            <div class="mt-5 text-center"><button class="btn btn-primary profile-button"
                                    type="submit">Update
                                    Profile</button></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class=" py-5">
                            {{-- <div class="d-flex justify-content-between align-items-center experience"><span>Order
                                History</span></div><br>
                        <div class="col-md-12 bg-dark">

                            @foreach ($orders as $order)
                                <div class="col-md-12">
                                    {{ $order }}
                                </div>
                                <br>
                            @endforeach

                        </div> --}}

                            <div class="card checkout-order-summary">
                                <div class="card-body">
                                    <div class="p-3 mb-3">
                                        <h5 class="font-size-24 mb-0">Order History
                                        </h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 table-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0" style="width: 110px;" scope="col">Product
                                                    </th>
                                                    <th class="border-top-0" scope="col">Product Desc</th>
                                                    <th class="border-top-0" scope="col">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    @foreach ($products as $product)
                                                        @if ($product->id == $order->product_id)
                                                            <tr>
                                                                <th scope="row"><img
                                                                        src="{{ asset('storage/vendor/products/images/' . $product->image) }}"
                                                                        alt="product-img" title="product-img"
                                                                        class="avatar-lg rounded">
                                                                </th>
                                                                <td>
                                                                    <h5 class="font-size-16 text-truncate"><a href="#"
                                                                            class="text-dark">{{ $product->name }}</a></h5>
                                                                    <p class="text-muted mb-0">
                                                                        <i class="bx bxs-star text-warning"></i>
                                                                        <i class="bx bxs-star text-warning"></i>
                                                                        <i class="bx bxs-star text-warning"></i>
                                                                        <i class="bx bxs-star text-warning"></i>
                                                                        <i class="bx bxs-star-half text-warning"></i>
                                                                    </p>
                                                                    <p class="text-muted mb-0 mt-1">Quantity:
                                                                        {{ $order->quantity }}</p>
                                                                    <p class="text-muted mb-0 mt-1">
                                                                        {{ $product->description }}
                                                                    </p>
                                                                </td>
                                                                <td>{{ $order->amount }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
        </div>



    </section>

@endsection

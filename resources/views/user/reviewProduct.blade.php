@extends('user.userHome')

@section('title', 'My Account')

@section('style')
    <style>
        @media (max-width: 767.98px) {
            .border-sm-start-none {
                border-left: none !important;
            }
        }


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
            overflow: scroll;

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



    <section style="background-color: #eee;">
        <div class="container p-5">
            <div class="row justify-content-center mb-0">
                <div class="col-md-12 col-xl-10">
                    <div class="card shadow-0 border rounded-0 m-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-3 col-xl-3 mb-0 mb-lg-0">
                                    <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                        <div class="container" style="max-height: 250px; overflow-y:auto">
                                            <img src="{{ asset('storage/vendor/products/images/' . $product->image) }}"
                                                class="w-100" />
                                        </div>
                                        <a href="#!">
                                            <div class="hover-overlay">
                                                <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-6">
                                    <h5>{{ $product->name }}</h5>
                                    <div class="d-flex flex-row">
                                        @php
                                            $totalReviews = 0;
                                            $count = 0;
                                            foreach ($product->reviews as $key => $review) {
                                                $totalReviews += $review->rating;
                                                $count += 1;
                                            }
                                            if ($count != 0) {
                                                $totalReviews = $totalReviews / $count;
                                            }

                                        @endphp


                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                @for ($i = 0; $i < $totalReviews; $i++)
                                                    <li class="list-inline-item"><i class="bi bi-star-fill"></i></li>
                                                @endfor
                                                @for ($i = $totalReviews; $i < 5; $i++)
                                                    <li class="list-inline-item"><i class="bi bi-star"></i></li>
                                                @endfor
                                                ({{ $count }})
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="mt-1 mb-0 text-muted small">


                                        @foreach ($variations as $variation)
                                            @if ($variation->id == $order->variation_id)
                                                <span>{{ $variation->name }}</span>
                                            @endif
                                        @endforeach

                                    </div>

                                    <p class=" mb-4 mb-md-0">
                                        {{ $product->description }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container mt-0 py-0 d-flex justify-content-center">

                <div class="card rounded-0" style="width: 86.5%;">
                    <div class="text-center">
                        <h4 class="text-center">Review Section</h4>
                    </div>
                    <form action="{{ route('reviewProduct', ['id' => $customer->id, 'order_id' => $order->id]) }}"
                        class="form-control rounded-3 border border-0" method="post">
                        @csrf
                        <label class="form-label" for="rating">Rate product out of 5:</label>
                        <input class="form-control" type="number" id="rating" max="5" name="rating">
                        <label class="form-label" for="review">Review the product:</label>
                        <textarea class="form-control" type="text" id="review" placeholder="How was the product?....." name="review"></textarea>
                        <input type="text" value="{{ $order->id }}" name="order_id" hidden>
                        <div class="text-center mt-3 mb-3">
                            <button type="submit" class="btn btn-success">Submit Review</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>




@endsection

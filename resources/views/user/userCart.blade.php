@extends('user.userHome')

@section('title', 'My Cart')

@section('style')

    <style>
        .quantity-container {
            display: flex;
            align-items: center;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
        }

        .quantity-btn {
            cursor: pointer;
            background-color: transparent;
            border: 0px;
        }

        @media (min-width: 1025px) {
            .h-custom {
                height: 100vh !important;
            }
        }
    </style>

@endsection

@section('body')



    <section class="">
        @php
            $totalPrice = 0;
            $shippingFee = 0;
            $tax = 0;
        @endphp
        <div class="container h-100 py-5">
            <div class="p-0 row d-flex justify-content-center align-items-center">
                <div class="col">

                    @if (Session::has('success'))
                        <div class="d-flex align-text-center justify-content-center">
                            <div class="col-md-4 alert alert-success alert-dismissible text center fade show">
                                <strong>Success!</strong> {{ Session::get('success') }}
                            </div>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="d-flex align-text-center justify-content-center">
                            <div class="col-md-4 alert alert-danger alert-dismissible text center fade show">
                                <strong>Error!</strong> {{ Session::get('error') }}
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="h5">Shopping Bag</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price per Item</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($userCart) != 0)

                                    @foreach ($userCart as $item)
                                        @foreach ($products as $product)
                                            @if ($product->id == $item->product_id)
                                                <tr>
                                                    <th scope="row">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('storage/vendor/products/images/' . $product->image) }}"
                                                                class="img-fluid rounded-3" style="width: 120px;"
                                                                alt="Book">
                                                            <div class="flex-column ms-4">
                                                                <p class="mb-2">{{ $product->name }}</p>
                                                                <p class="mb-0">Daniel Kahneman</p>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <td class="align-middle">
                                                        <p class="mb-0" style="font-weight: 500;">Digital</p>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="d-flex flex-row">

                                                            <div class="quantity-container">
                                                                {{-- <button class="quantity-btn" id="decrease"><i
                                                                        class="bi bi-dash"></i></button> --}}
                                                                <p class="mb-0" style="font-weight: 500;" id="quantity">
                                                                    {{ $item->quantity }}</p>
                                                                {{-- <button class="quantity-btn" id="increase"><i
                                                                        class="bi bi-plus"></i></button> --}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <p class="mb-0" style="font-weight: 500;" id="PricePerItem">
                                                            {{ $item->price }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle">
                                                        <p class="mb-0" style="font-weight: 500;" id="totalPrice">
                                                            {{ $item->price * $item->quantity }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a class="mb-0 text-decoration-none"
                                                            href="{{ route('deleteCartItem', ['id' => $customer->id, 'item_id' => $item->id]) }}"
                                                            style="font-weight: 500; cursor:pointer;">
                                                            Remove
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php
                                                    $totalPrice += $item->price * $item->quantity;
                                                    $shippingFee += 100;
                                                    $tax += 2;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach
                                @else
                                    <p>No Product Found</p>
                                    <a class="btn btn-primary" href="{{ route('home') }}">Continue Shopping</a>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="card shadow-2-strong mb-5 mb-lg-0 mb-5" style="border-radius: 16px;">
                        <div class="card-body p-4">

                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">
                                    <form>
                                        {{-- <div class="d-flex flex-row pb-3">
                                            <div class="d-flex align-items-center pe-2">
                                                <input class="form-check-input" type="radio" name="radioNoLabel"
                                                    id="radioNoLabel1v" value="" aria-label="..." checked />
                                            </div>
                                            <div class="rounded border w-100 p-3">
                                                <p class="d-flex align-items-center mb-0">
                                                    <i class="fab fa-cc-mastercard fa-2x text-dark pe-2"></i>Credit
                                                    Card
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row pb-3">
                                            <div class="d-flex align-items-center pe-2">
                                                <input class="form-check-input" type="radio" name="radioNoLabel"
                                                    id="radioNoLabel2v" value="" aria-label="..." />
                                            </div>
                                            <div class="rounded border w-100 p-3">
                                                <p class="d-flex align-items-center mb-0">
                                                    <i class="fab fa-cc-visa fa-2x fa-lg text-dark pe-2"></i>Debit Card
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row">
                                            <div class="d-flex align-items-center pe-2">
                                                <input class="form-check-input" type="radio" name="radioNoLabel"
                                                    id="radioNoLabel3v" value="" aria-label="..." />
                                            </div>
                                            <div class="rounded border w-100 p-3">
                                                <p class="d-flex align-items-center mb-0">
                                                    <i class="fab fa-cc-paypal fa-2x fa-lg text-dark pe-2"></i>Cash on
                                                    delivery
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div> --}}
                                        <div class="col-md-6 col-lg-4 col-xl-6">
                                            {{-- <div class="row">
                    <div class="col-12 col-xl-6">
                      <div class="form-outline mb-4 mb-xl-5">
                        <input type="text" id="typeName" class="form-control form-control-lg" siez="17"
                          placeholder="John Smith" />
                        <label class="form-label" for="typeName">Name on card</label>
                      </div>
  
                      <div class="form-outline mb-4 mb-xl-5">
                        <input type="text" id="typeExp" class="form-control form-control-lg" placeholder="MM/YY"
                          size="7" id="exp" minlength="7" maxlength="7" />
                        <label class="form-label" for="typeExp">Expiration</label>
                      </div>
                    </div>
                    <div class="col-12 col-xl-6">
                      <div class="form-outline mb-4 mb-xl-5">
                        <input type="text" id="typeText" class="form-control form-control-lg" siez="17"
                          placeholder="1111 2222 3333 4444" minlength="19" maxlength="19" />
                        <label class="form-label" for="typeText">Card Number</label>
                      </div>
  
                      <div class="form-outline mb-4 mb-xl-5">
                        <input type="password" id="typeText" class="form-control form-control-lg"
                          placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3" />
                        <label class="form-label" for="typeText">Cvv</label>
                      </div>
                    </div>
                  </div> --}}
                                        </div>
                                        <div class="">
                                            <div class="d-flex justify-content-between" style="font-weight: 500;">
                                                <p class="mb-2">Subtotal: </p>&nbsp; &nbsp;
                                                <p class="mb-2">{{ $totalPrice . ' pkr' }}</p>
                                            </div>

                                            <div class="d-flex justify-content-between" style="font-weight: 500;">
                                                <p class="mb-0">Shipping: </p>&nbsp;&nbsp;
                                                <p class="mb-0">{{ $shippingFee . ' pkr' }}</p>
                                            </div>

                                            <hr class="my-4">

                                            <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                                                <p class="mb-2">Total pkr (tax + shipping included)</p>
                                                <p class="mb-2">{{ $totalPrice + $shippingFee + $tax }}</p>
                                            </div>

                                            {{-- checkout address page --}}
                                            <a type="button" href="{{ route('checkoutView', ['id' => $customer->id]) }}"
                                                class="btn btn-primary btn-block btn-lg">
                                                <div class="d-flex justify-content-between">
                                                    <span>Checkout</span> &nbsp;
                                                    <span>{{ $totalPrice + $shippingFee + $tax }} pkr</span>
                                                </div>
                                            </a>

                                            {{-- <a type="button"
                                                href="{{ route('stripe.checkout', ['id' => $customer->id]) }}"
                                                class="btn btn-primary btn-block btn-lg">
                                                <div class="d-flex justify-content-between">
                                                    <span>Checkout</span> &nbsp;
                                                    <span>{{ $totalPrice + $shippingFee + $tax }} pkr</span>
                                                </div>
                                            </a> --}}

                                        </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </section>



    <script>
        const decreaseBtn = document.getElementById('decrease');
        const increaseBtn = document.getElementById('increase');
        const quantityInput = document.getElementById('quantity');
        const totalPriceElement = document.getElementById('totalPrice');
        const pricePerItem = document.getElementById('PricePerItem').textContent; // Set your price per item here

        function updateTotalPrice() {
            const quantity = parseInt(quantityInput.value);
            const totalPrice = quantity * pricePerItem;
            newPrice = parseFloat(totalPrice.toFixed(2));
            totalPriceElement.textContent = newPrice;
        }

        decreaseBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                currentValue--;
                quantityInput.value = currentValue;
                updateTotalPrice();
            }
        });

        increaseBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            currentValue++;
            quantityInput.value = currentValue;
            updateTotalPrice();
        });

        quantityInput.addEventListener('input', () => {
            updateTotalPrice();
        });

        updateTotalPrice(); // Initialize total price on page load
    </script>

@endsection

<!--Main layout-->
@if (Session::has('success'))
    <div class="d-flex align-text-center justify-content-center">
        <div class="col-md-4 alert alert-success alert-dismissible text center fade show">
            <strong>Added To Cart!</strong> {{ Session::get('success') }}
        </div>
    </div>
@endif
<main class="mt-5 pt-4">





    <div class="container mt-5">
        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-md-6 mb-4">
                <img src="{{ asset('storage/vendor/products/images/' . $product->image) }}" id="product-image"
                    class="img-fluid" alt="image" />
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-6 mb-4">
                <!--Content-->
                <div class="p-4">




                    <strong>
                        <p class="" style="font-size: 20px;">{{ $product->name }}</p>
                    </strong>






                    <p>{{ $product->description }}</p>

                    <p class="lead">
                        {{-- <span class="me-1">
                            <del>$200</del>
                        </span> --}}
                        <span id="price">Rs.{{ $product->price }}/-</span>
                    </p>

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


                    <form class=" justify-content-left" method="get"
                        @if (Session::has('customer')) action= "{{ route('addToCart', ['customerId' => $customerId, 'productId' => $product->id]) }}"
                        @else 
                        action= "{{ route('customerLogin') }}" @endif>

                        <input type="number" id="priceInput" value="{{ $product->price }}" name="price" hidden />

                        <!-- Product Variations -->
                        <div class="row">
                            <div class="col-md-6">


                                <div class="">
                                    <label for="variation-Select" class="form-label">Variations</label>
                                    <select class="form-select" id="variation-select" onchange="updateImage()"
                                        name="variation">
                                        <option value=""
                                            data-image-url="{{ asset('storage/vendor/products/images/' . $product->image) }}"
                                            data-price="0"
                                            data-variation='{"color": null, "weight": null, "size": null, "material": null}'
                                            data-null = "1">
                                            Select Variation</option>
                                        @foreach ($product->variations as $variation)
                                            <option value="{{ $variation->id }}"
                                                data-image-url="{{ asset('storage/vendor/products/images/' . $variation->pivot->image) }}"
                                                data-price="{{ $variation->pivot->price_modifier }}"
                                                data-variation="{{ $variation }}"
                                                data-quantity="{{ $variation->pivot->quantity }}" data-null= "0">
                                                {{ $variation->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('variation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="py-3 align-items-center justify-content-center" id="variation-data">

                                    </div>
                                </div>




                            </div>
                        </div>
                        <!-- Default input -->
                        <div class="form-outline me-1 mb-2" style="width: 100px;">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" value="1" min="1" class="form-control"
                                name="quantity" disabled />

                            @error('quantity')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <input type="text" value="{{ $product->id }}" name="productId" hidden>
                        </div>
                        <p id="stock"></p>

                        @if (Session::has('customer'))
                            <button class="btn btn-primary mt-3" type="submit" id="cartBtn1">
                                Add to cart
                                <i class="fas fa-shopping-cart ms-1" id="cartBtn1"></i>
                            </button>
                        @else
                            {{-- <a class="btn btn-primary mt-3" href="{{ route('customerLogin') }}" id="cartBtn2">
                                Sign In to add into cart
                                <i class="fas fa-shopping-cart ms-1" id="cartBtn2"></i>
                            </a> --}}
                            <button class="btn btn-primary mt-3" type="submit" id="cartBtn1">
                                Sign In to add into cart
                                <i class="fas fa-shopping-cart ms-1" id="cartBtn1"></i>
                            </button>
                        @endif


                    </form>
                </div>
                <!--Content-->
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->

        <hr />

        <!--Grid row-->
        <div class="row
                        d-flex justify-content-center">
            <!--Grid column-->
            <div class="col-md-10 text-center">
                <h4 class="my-4 h4"><a class="text-decoration-none text-dark"
                        href="{{ route('ShopPage', ['id' => $store->id]) }}">{{ $store->name }}</a>
                </h4>

                <p>{{ $store->description }}</p>
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->

        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            @foreach ($product->variations as $key => $variation)
                @if ($key === 3)
                @break
            @endif
            <div class="col-lg-4 col-md-12 mb-4 p-5">
                <img src="{{ asset('storage/vendor/products/images/' . $variation->pivot->image) }}"
                    class="img-fluid" alt="product-image" />
            </div>
        @endforeach

        <!--Grid column-->
    </div>
    <hr>
    <div class="container">
        <div class="text-center">
            <h4>Reviews & Rating</h4>
        </div>

        <div>
            @if (count($product->reviews) != 0)
                @foreach ($product->reviews as $review)
                    @foreach ($customers as $r_customer)
                        @if ($r_customer->id == $review->customer_id)
                            <section class="p-4 p-md-5 text-center text-lg-start shadow-1-strong rounded">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-10">
                                        <div class="card">
                                            <div class="card-body m-3">
                                                <div class="row">
                                                    <div
                                                        class="col-lg-2 d-flex justify-content-center align-items-center mb-4 mb-lg-0">
                                                        <img src="{{ asset($r_customer->avatar ? 'Storage/customer/avatars/' . $r_customer->avatar : 'images/default/user.png') }}"
                                                            class="rounded-circle img-fluid shadow-1"
                                                            alt="woman avatar" width="100" height="100" />
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <p class="text-muted fw-light mb-4">
                                                            {{ $review->review }}
                                                        </p>
                                                        @for ($i = 0; $i < $review->rating; $i++)
                                                            <li class="list-inline-item"><i
                                                                    class="bi bi-star-fill"></i>
                                                            </li>
                                                        @endfor
                                                        <p class="fw-bold lead mb-2">
                                                            <strong>{{ $r_customer->name }}</strong>
                                                        </p>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                    @endforeach
                @endforeach
            @else
                <div class="text-center">
                    <h6>No Reviews Yet</h6>
                </div>
            @endif
        </div>
    </div>
    <!--Grid row-->
</div>

<script>
    function updateImage() {

        // set max value for quantity input
        var selectBox = document.getElementById("variation-select");
        var selectedOption = selectBox.options[selectBox.selectedIndex];
        var quantityInput = document.getElementById("quantity");
        var quantityInStock = selectedOption.getAttribute('data-quantity');
        var cartBtn1 = document.getElementById("cartBtn1");
        var cartBtn2 = document.getElementById("cartBtn2");
        var stockText = document.getElementById("stock");
        var selectoption = selectedOption.getAttribute('data-null');
        // Set the max attribute of the quantity input field
        quantityInput.max = quantityInStock;
        quantityInput.disabled = false;





        @if (Session::has('customer'))

            if (quantityInStock <= 0 && selectoption == "0") {
                quantityInput.disabled = true;
                cartBtn1.disabled = true;
                //cartBtn2.classList.add("disabled");

                cartBtn1.textContent = "Out Of Stock";
                stockText.textContent = "";
                cartBtn1.classList.remove('btn-primary');
                cartBtn1.classList.add('btn-danger');



                //cartBtn2.textContent = "Out Of Stock";
            } else {
                cartBtn1.disabled = false;
                cartBtn1.textContent = "Add To Cart";
                cartBtn1.classList.remove('btn-danger');
                cartBtn1.classList.add('btn-primary');
                //cartBtn2.classList.remove("disabled");
                //cartBtn2.textContent = "Sign in to Add To Cart";
                stockText.textContent = "In Stock";
                stockText.classList.remove('text-danger');
                stockText.classList.add('text-success');

            }
        @else
            if (quantityInStock <= 0 && selectoption == "0") {
                quantityInput.disabled = true;
                //cartBtn1.disabled = true;
                cartBtn1.classList.add("disabled");

                cartBtn1.textContent = "Out Of Stock";

                stockText.textContent = "";
                cartBtn1.classList.remove('btn-primary');
                cartBtn1.classList.add('btn-danger');
            } else {
                // cartBtn1.disabled = false;
                // cartBtn1.textContent = "Add To Cart";
                cartBtn1.classList.remove("disabled");
                cartBtn1.classList.remove('btn-danger');
                cartBtn1.classList.add('btn-primary');
                cartBtn1.textContent = "Sign in to Add To Cart";

                stockText.textContent = "In Stock";
                stockText.classList.remove('text-danger');
                stockText.classList.add('text-success');


            }
        @endif

        //changing the image according to the selected variation
        var selectBox = document.getElementById("variation-select");
        var selectedOption = selectBox.options[selectBox.selectedIndex];
        var imageElement = document.getElementById("product-image");
        var price = document.getElementById("price");
        var priceInput = document.getElementById("priceInput");
        var variationData = document.getElementById("variation-data");

        var originalPrice = {{ $product->price }};

        var newImageUrl = selectedOption.getAttribute('data-image-url');
        var priceModifier = Number(selectedOption.getAttribute('data-price'));
        var variationObjectString = selectedOption.getAttribute('data-variation');

        var updatedPrice = originalPrice + priceModifier;
        var newPrice = updatedPrice;
        imageElement.src = newImageUrl;
        price.textContent = newPrice;
        priceInput.value = newPrice;

        // Parse the variation object string into a JavaScript object
        var variationObject = JSON.parse(variationObjectString);

        // Constructing the variation data string
        var variationDataString = '';
        if (variationObject.color !== null) {
            variationDataString +=
                `Color: <span class="" style="background-color:${variationObject.color}; width:20px; height:20px; border-radius:50%; display:inline-block;"></span>,`;
        }
        if (variationObject.weight !== null) {
            variationDataString += `Weight: ${variationObject.weight}, `;
        }
        if (variationObject.size !== null) {
            variationDataString += `Size: ${variationObject.size}, `;
        }
        if (variationObject.material !== null) {
            variationDataString += `Material: ${variationObject.material}, `;
        }

        // Remove trailing comma and space
        variationDataString = variationDataString.replace(/,\s*$/, "");

        variationData.innerHTML = variationDataString;
    }
</script>

</main>
<!--Main layout-->

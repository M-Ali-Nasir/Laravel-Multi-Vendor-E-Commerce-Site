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


                    <p class="lead">
                        {{-- <span class="me-1">
                            <del>$200</del>
                        </span> --}}
                        <span id="price">{{ $product->price }}</span> &nbsp; <span>PKR/-</span>
                    </p>

                    <strong>
                        <p style="font-size: 20px;">{{ $product->name }}</p>
                    </strong>

                    <p>{{ $product->description }}</p>

                    <form class=" justify-content-left" method="get"
                        action="{{ route('addToCart', ['customerId' => $customerId, 'productId' => $product->id]) }}">

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
                                            data-variation='{"color": null, "weight": null, "size": null, "material": null}'>
                                            Select Variation</option>
                                        @foreach ($product->variations as $variation)
                                            <option value="{{ $variation->id }}"
                                                data-image-url="{{ asset('storage/vendor/products/images/' . $variation->pivot->image) }}"
                                                data-price="{{ $variation->pivot->price_modifier }}"
                                                data-variation="{{ $variation }}"
                                                data-quantity="{{ $variation->pivot->quantity }}">
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


                        </div>

                        @if (Session::has('customer'))
                            <button class="btn btn-primary mt-3" type="submit" id="cartBtn1">
                                Add to cart
                                <i class="fas fa-shopping-cart ms-1"></i>
                            </button>
                        @else
                            <a class="btn btn-primary mt-3" href="{{ route('customerLogin') }}" id="cartBtn2">
                                Sign In to add into cart
                                <i class="fas fa-shopping-cart ms-1"></i>
                            </a>
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
        <div class="row d-flex justify-content-center">
            <!--Grid column-->
            <div class="col-md-6 text-center">
                <h4 class="my-4 h4">Additional information</h4>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit modi sapiente illo soluta
                    odit voluptates, quibusdam officia. Neque quibusdam quas a quis porro? Molestias illo neque eum in
                    laborum.</p>
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
                    class="img-fluid" alt="" />
            </div>
        @endforeach

        <!--Grid column-->
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

        // Set the max attribute of the quantity input field
        quantityInput.max = quantityInStock;
        quantityInput.disabled = false;





        @if (Session::has('customer'))

            if (quantityInStock <= 0) {
                quantityInput.disabled = true;
                cartBtn1.disabled = true;
                //cartBtn2.classList.add("disabled");

                cartBtn1.textContent = "Out Of Stock";

                //cartBtn2.textContent = "Out Of Stock";
            } else {
                cartBtn1.disabled = false;
                cartBtn1.textContent = "Add To Cart";
                //cartBtn2.classList.remove("disabled");
                //cartBtn2.textContent = "Sign in to Add To Cart";

            }
        @else
            if (quantityInStock <= 0) {
                quantityInput.disabled = true;
                //cartBtn1.disabled = true;
                cartBtn2.classList.add("disabled");

                //cartBtn1.textContent = "Out Of Stock";

                cartBtn2.textContent = "Out Of Stock";
            } else {
                // cartBtn1.disabled = false;
                // cartBtn1.textContent = "Add To Cart";
                cartBtn2.classList.remove("disabled");
                cartBtn2.textContent = "Sign in to Add To Cart";

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

        var newPrice = originalPrice + priceModifier;
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

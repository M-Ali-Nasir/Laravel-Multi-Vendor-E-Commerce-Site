@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Edit Product')


@section('mainBody')




    @if (empty($store))

        <div class="text-center py-5 my-5">
            <i class="far fa-sad-tear" style="font-size: 5rem;"></i>
            <p class="lead">Oops! You don't have Store. You need to first create a Store to add Products on it.</p>
            <a href="{{ route('createStorePage', ['vendorName' => $vendor->name]) }}" class="btn btn-primary">Create a
                New</a>
        </div>
    @else
        <!-- Create Product Form -->
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
        </svg>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <strong>Congratulations!</strong> {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form class="px-5 py-5" action="{{ route('editProduct', ['id' => $store->id, 'product_id' => $product->id]) }}"
            method="post" enctype="multipart/form-data" id="productForm">
            @csrf

            <!-- Form Name -->






            <div class="container">




                <div class="row marketing">
                    <div class="col-lg-6">
                        <legend>Edit Product</legend>

                        <!-- Product Name-->
                        <div class="form-group mb-2">
                            <label class="col-md-4 control-label" for="name">Product Name</label>
                            <div class="col-md-8">
                                <input id="name" name="name" type="text" placeholder="product name"
                                    class="form-control input-md" required="" value="{{ $product->name }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Product Category -->
                        @if (count($categories) != 0)


                            <div class="form-group mb-2">
                                <label class="col-md-4 control-label" for="category">Product Category</label>

                                <div class="col-md-8">
                                    <select id="category" name="category" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" id="category-{{ $category->id }}"
                                                @if ($category->id === $product->cat_id) selected @endif>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>


                        @endif

                        <!-- Product Price-->
                        <div class="form-group mb-2">
                            <label class="col-md-4 control-label" for="price">Product Price</label>
                            <div class="col-md-8">
                                <input id="price" name="price" type="number" placeholder="PKR"
                                    class="form-control input-md" required="" value="{{ $product->price }}">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        @if (!empty($paymentMethods))
                            <!-- Multiple Checkboxes (inline) -->
                            <div class="form-group mb-2">
                                <label class="col-md-8 mb-1 control-label" for="checkboxes">Select Payment Methods for this
                                    Product
                                </label>
                                <div class="col-md-8">
                                    @foreach ($paymentMethods as $key => $method)
                                        <label class="checkbox-inline" for="checkboxes-{{ $method->id }}">
                                            <input type="checkbox" name="paymentMethod[{{ $loop->index }}]"
                                                id="checkboxes-{{ $method->id }}" value="{{ $method->id }}"
                                                @foreach ($product->paymentMethods as $methods)
                                @if ($method->id === $methods->id)
                                checked
                                @endif @endforeach>
                                            {{ $key + 1 }}: {{ $method->payment_method }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('paymentMethod')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        @endif




                        <!-- Image upload -->
                        <div class="form-group mb-2">
                            <label class="col-md-4 control-label" for="image">Product Image</label>
                            <div class="col-md-8">
                                <input id="image" name="image" class="input-file" type="file">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group mb-2">
                            <label class="col-md-4 control-label" for="description">Description</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="description" name="description" placeholder="beriefly write about the product">{{ $product->description }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-2">



                            @if (count($variations) != 0)
                                <div class="form-group mb-2">
                                    <label class="col-md-4 control-label" for="variations">Variations</label>
                                    @foreach ($variations as $variation)
                                        <div class="form-group row">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-8 mb-4">
                                                            <div class="checkbox">
                                                                <label for="variations-{{ $variation->id }}">
                                                                    <input type="checkbox"
                                                                        name="variations[{{ $loop->index }}][id]"
                                                                        id="variations-{{ $variation->id }}"
                                                                        value="{{ $variation->id }}"
                                                                        @foreach ($product->variations as $p_variation)
                                                                @if ($p_variation->id === $variation->id)
                                                                    checked
                                                                @endif @endforeach>
                                                                    {{ $variation->name }}
                                                                </label>
                                                                <div class="form-group mb-2 variations-fields"
                                                                    style="display: block;"
                                                                    @foreach ($product->variations as $product_variation)
                                                        @if ($product_variation->id != $variation->id)
                                                        style="display: none"
                                                        @endif @endforeach>
                                                                    <div class="">
                                                                        <input id="price"
                                                                            name="variations[{{ $loop->index }}][quantity]"
                                                                            type="number" placeholder="Quantity"
                                                                            class="form-control input-md"
                                                                            @foreach ($product->variations as $product_variation)
                                                                    @if ($product_variation->id === $variation->id)
                                                                    value="{{ $product_variation->pivot->quantity }}"
                                                                    @endif @endforeach>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-2 variations-fields"
                                                                    style="display: block;"
                                                                    @foreach ($product->variations as $product_variation)
                                                        @if ($product_variation->id != $variation->id)
                                                        style="display: none"
                                                        @endif @endforeach>
                                                                    <div class="">
                                                                        <input id="price"
                                                                            name="variations[{{ $loop->index }}][price_modifier]"
                                                                            type="number" placeholder="Price Modifier"
                                                                            class="form-control input-md"
                                                                            @foreach ($product->variations as $product_variation)
                                                                    @if ($product_variation->id === $variation->id)
                                                                    value="{{ $product_variation->pivot->price_modifier }}"
                                                                    @endif @endforeach>
                                                                    </div>
                                                                    <div class="form-group mb-2 variations-fields"
                                                                        @foreach ($product->variations as $product_variation)
                                                                    @if ($product_variation->id != $variation->id)
                                                                    style="display: none"
                                                                    @endif @endforeach>
                                                                        <div class="">
                                                                            <label for="img">Product image for this
                                                                                variation</label>
                                                                            <input id="img"
                                                                                name="variations[{{ $loop->index }}][img]"
                                                                                type="file"
                                                                                class="form-control input-md">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @error('variations')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                            @error('checked_variations')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Hidden input field to track checked variations -->
                            <input type="hidden" name="checked_variations[]">



                        </div>
                    </div>
                </div>



            </div>

            <hr class="my-2">

            <button type="submit" class="btn btn-outline-success mx-2">Save Product</button>
        </form>

    @endif


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var isChecked = $(this).prop('checked');
                $(this).closest('.checkbox').find('.variations-fields').toggle(isChecked);
            });
        });

        ;

        document.addEventListener('DOMContentLoaded', function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var checkedVariations = document.querySelector(
                        'input[name="checked_variations[]"]');
                    var checkedIds = Array.from(document.querySelectorAll(
                        'input[type="checkbox"]:checked')).map(function(checkbox) {
                        return checkbox.value;
                    });
                    checkedVariations.value = JSON.stringify(checkedIds);
                });
            });
        });
    </script>
@endsection

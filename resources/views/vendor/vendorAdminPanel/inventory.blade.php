@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Inventory')


@section('mainBody')



    @if (empty($store) || count($products) === 0)

        <div class="text-center py-5 my-5">
            <i class="far fa-sad-tear" style="font-size: 5rem;"></i>
            <p class="lead">Oops! You don't have any product. You need to first add products.</p>
            <a href="{{ route('addProductPage', ['vendorName' => $vendor->name]) }}" class="btn btn-primary">Add a
                New</a>
        </div>
    @else
        <div class="container mt-5">
            <div class="row">
                @foreach ($products as $key => $product)
                    <div class="col-md-12 mb-1">

                        <div class="card border-0">
                            <div class="row">
                                <div class="col-md-1 mb-2 d-flex ">
                                    <p class="align-self-center">{{ $key + 1 }}&nbsp;</p>
                                    <img src="{{ asset('storage/vendor/products/images/' . $product->image) }}"
                                        class="" alt="{{ $product->name }}" style="width: 50px; height:50px;">
                                </div>

                                <div class="col-md-6 mb-2">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <div class="container" style="width: 100%; max-height: 50px; overflow-y:hidden; ">
                                        <p class="card-text">Description: {{ $product->description }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <h5 class="card-title"></h5>
                                    @foreach ($categories as $category)
                                        @if ($category->id === $product->cat_id)
                                            <p class="card-text">Category: {{ $category->name }}</p>
                                        @endif
                                    @endforeach
                                    <div class="d-flex">

                                        {{-- <p class="card-text">Payment Methods:                            
                                
                                @foreach ($product->paymentMethods as $method)
                                
                                    {{ $method->payment_method}}|                            
                                                                
                                @endforeach
                            </p>  --}}
                                    </div>


                                </div>
                                <div class="col-md-2 mb-2 text-end">
                                    <h6>Stock</h6>
                                    @foreach ($variations as $variation)
                                        @foreach ($product->variations as $p_variation)
                                            @if ($p_variation->id == $variation->id)
                                                <p>

                                                    {{ $variation->name }} = {{ $p_variation->pivot->quantity }}
                                                </p>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer py-0 border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">


                                        <form
                                            action="{{ route('deleteProduct', ['id' => $store->id, 'product_id' => $product->id]) }}"
                                            method="get">
                                            @csrf
                                            <a href="{{ route('editProductPage', ['vendorName' => $vendor->name, 'id' => $product->id]) }}"
                                                class="btn btn-sm btn-outline-secondary me-2 py-0">Edit Inventory</a>
                                            {{-- @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-0"
                                                onclick="return confirm('Are you sure you want to delete this product?')">Delete</button> --}}
                                        </form>
                                    </div>
                                    <small class="text-muted">Last updated:
                                        {{ $product->updated_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>


                    </div>
                    <hr>
                @endforeach

            </div>
        </div>

    @endif

@endsection

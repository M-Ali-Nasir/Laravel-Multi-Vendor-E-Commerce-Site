@extends('user.userHome')

@section('title', 'About')

@section('search_placeholder','Search Shops')

@section('search_action','#')

@section('body')

@include('components.home.slider')

<figure class="text-center mt-5">
    <blockquote class="blockquote">
        <p>Top Stores: Discover the Best Sellers</p>
    </blockquote>
    <figcaption class="blockquote-footer">
        Explore a curated selection of top-rated stores, handpicked for you
    </figcaption>
</figure>


@if (count($stores) != 0)
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Product Cards -->
            <div class="row">
                <!-- Product Cards Here -->
                <!-- Add more product cards as needed -->
                
                    @foreach ($stores as $store)
                    <div class="col-md-2 mb-4">
                        <a href="{{ route('ShopPage',['id' => $store->id]) }}">
                            <div class="card position-relative">
                                <img src="https://via.placeholder.com/300" class="card-img" alt="...">
                                <div class="card-img-overlay d-flex flex-column justify-content-center">
                                    <h5 class="card-title text-center text-white">{{ $store->name }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                
                
            </div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link border-0" href="#" tabindex="-1" aria-disabled="true">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    </li>
                    <!-- Add more page numbers as needed -->
                    <li class="page-item">
                        <a class="page-link border-0" href="#">Next <i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    @endif
</div>



@endsection
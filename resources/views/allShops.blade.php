@extends('user.userHome')

@section('title', 'All Shops')




<style>
    .card {
        position: relative;
        overflow: hidden;
        /* Ensure the overlay stays within the card boundaries */
    }

    .card-img-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        /* Semi-transparent black overlay */
        opacity: 0;
        /* Hide overlay by default */
        transition: opacity 0.3s ease;
        /* Smooth transition for opacity */
    }

    .card:hover .card-img-overlay {
        opacity: 1;
        /* Show overlay on hover */
    }
</style>


@section('body')

    @include('components.home.slider')


    @if (count($stores) != 0)
        <figure class="text-center mt-5">
            <blockquote class="blockquote">
                <p>Top Stores: Discover the Best Sellers</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                Explore a curated selection of top-rated stores, handpicked for you
            </figcaption>
        </figure>



        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Product Cards -->
                    <div class="row">
                        <!-- Product Cards Here -->
                        <!-- Add more product cards as needed -->

                        @foreach ($stores as $store)
                            <div class="col-md-2 mb-4 text-center">
                                <a href="{{ route('ShopPage', ['id' => $store->id]) }}"
                                    class="text-decoration-none text-dark">
                                    <div class="card position-relative" style="height: 100px;">
                                        <img src="{{ asset('storage/vendor/store/banner/' . $store->banner) }}"
                                            class="card-img h-100" alt="...">
                                        <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                            <h5 class="card-title text-center text-white">{{ $store->name }}</h5>
                                        </div>
                                    </div>

                                    <span>{{ $store->name }}</span>
                                </a>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
            <!-- Pagination -->
            {{-- <div class="row">
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
            </div> --}}


        </div>
    @endif



@endsection

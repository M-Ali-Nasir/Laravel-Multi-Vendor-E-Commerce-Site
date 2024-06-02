@if (count($stores) != 0)

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


    <figure class="text-center mt-5">
        <blockquote class="blockquote">
            <p>Discover the Best Sellers</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            Explore a curated selection of top-rated stores only for you
        </figcaption>
    </figure>



    <div class="container py-2">
        <div class="row align-items-center justify-content-center">


            @foreach ($stores as $store)
                <div class="col-md-2 mb-4 text-center">
                    <a href="{{ route('ShopPage', ['id' => $store->id]) }}" class="text-decoration-none text-dark">
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
@endif

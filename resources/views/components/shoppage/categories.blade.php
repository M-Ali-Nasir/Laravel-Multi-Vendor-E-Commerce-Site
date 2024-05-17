@if (count($categories) != 0)
    <figure class="text-center mt-5">
        <blockquote class="blockquote">
            <p>Shop Our Extensive Range of Categories</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            Discover Quality Items Across Various Categories
        </figcaption>
    </figure>



    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">





    <div class="slide-container swiper">
        <div class="slide-content">
            <div class="card-wrapper swiper-wrapper">
                @foreach ($categories as $category)
                    <div class="card swiper-slide">

                        <div class="card c-card text-dark card-has-bg click-col"
                            style="background-image:url('{{ asset('storage/vendor/products/category/images/' . $category->image) }}'); background-size:cover;">
                            <img class="card-img d-none" src="https://source.unsplash.com/600x900/?tech,street"
                                alt="Creative Manner Design Lorem Ipsum Sit Amet Consectetur dipisi?">
                            <div class="card-img-overlay d-flex flex-column">
                                <div class="card-body">
                                    <small class="card-meta mb-2">Category:</small>
                                    <h4 class="card-title mt-0 "><a class="text-dark" herf="https://creativemanner.com">
                                            {{ $category->name }}</a></h4>
                                    <small><i class="far fa-clock"></i>Created at:
                                        {{ \Carbon\Carbon::parse($category->created_at)->format('F d, Y') }}</small>
                                </div>
                                <div class="card-footer">
                                    <div class="media">
                                        <img class="mr-3 rounded-circle"
                                            src="{{ asset('storage/vendor/avatars/default.png') }}"
                                            alt="Generic placeholder image" style="max-width:50px">
                                        <div class="media-body">
                                            <h6 class="my-0 text-dark d-block">


                                                {{ $vendor->name }}

                                            </h6>
                                            <small>

                                                {{ $store->name }}

                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
        <div class="swiper-button-next swiper-navBtn"></div>
        <div class="swiper-button-prev swiper-navBtn"></div>
        <div class="swiper-pagination"></div>
    </div>





    <script>
        var categories = {{ count($categories) }};
    </script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <!-- JavaScript -->
    <script src="{{ asset('js/script.js') }}"></script>


@endif

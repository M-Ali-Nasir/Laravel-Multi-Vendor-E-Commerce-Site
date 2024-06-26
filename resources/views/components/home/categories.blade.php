@if (count($categories) != 0)
    <figure class="text-center mt-1">
        <blockquote class="blockquote">
            <p>Shop Extensive Range of Categories</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            Discover items across various categories
        </figcaption>
    </figure>



    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">








    <div class="slide-container swiper w-100 pt-2 pb-4 px-3">
        <div class="slide-content">
            <div class="card-wrapper swiper-wrapper">
                @foreach ($categories as $category)
                    <div class="card swiper-slide">




                        <div class="col-md-12">
                            <a class="text-dark" href="{{ route('categoryPage', ['id' => $category->id]) }}"
                                data-abc="true">
                                <div class="product-wrapper mb-45 text-center" style="height: 200px;">
                                    <img src="{{ asset('storage/vendor/products/category/images/' . $category->image) }}"
                                        alt="category-image" style="background-size:cover; width:100%; height:175px;">
                                    <div class="product-action">
                                        <div class="product-action-style w-100">

                                            {{ $category->name }}

                                        </div>
                                    </div>

                                </div>
                            </a>
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

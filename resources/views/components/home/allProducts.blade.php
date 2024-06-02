<style>
    .mt-100 {
        margin-top: 100px;
    }

    .card {
        border-radius: 7px !important;
        border-color: #e1e7ec;

    }

    .card:hover {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .mb-30 {
        margin-bottom: 30px !important;
    }

    .card-img-tiles {
        display: block;
        border-bottom: 1px solid #e1e7ec;
    }

    a {
        color: #0da9ef;
        text-decoration: none !important;
    }

    .card-img-tiles>.inner {
        display: table;
        width: 100%;

    }

    .card-img-tiles .main-img,
    .card-img-tiles .thumblist {
        display: table-cell;
        width: 65%;
        padding: 15px;
        vertical-align: middle;
    }

    .card-img-tiles .main-img>img:last-child,
    .card-img-tiles .thumblist>img:last-child {
        margin-bottom: 0;
    }

    .card-img-tiles .main-img>img,
    .card-img-tiles .thumblist>img {
        display: block;
        width: 100%;
        margin-bottom: 6px;
    }

    .thumblist {
        width: 35%;
        border-left: 1px solid #e1e7ec !important;
        display: table-cell;
        width: 65%;
        padding: 15px;
        vertical-align: middle;
        height: 200px;
    }



    .card-img-tiles .thumblist>img {
        display: block;
        width: 100%;
        margin-bottom: 6px;

    }

    .btn-group-sm>.btn,
    .btn-sm {
        padding: .45rem .5rem !important;
        font-size: .875rem;
        line-height: 1.5;
        border-radius: .2rem;
    }
</style>


@if (count($products) != 0)
    <figure class="text-center mt-4">
        <blockquote class="blockquote">
            <p>Browse All Products</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            Find everything you're looking for in our diverse collection
        </figcaption>
    </figure>



    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Product Cards -->
                <div class="row" id="product-list">
                    <!-- Product Cards Here -->
                    <!-- Add more product cards as needed -->


                    @foreach ($products as $product)
                        <div class="col-md-3 col-sm-6 p-2 ">
                            <div class="card mb-30 border-0">
                                <a class="card-img-tiles"
                                    href="{{ route('productView', ['product_id' => $product->id]) }}" data-abc="true">
                                    <div class="inner">
                                        <div class="main-img"><img
                                                src="{{ asset('storage/vendor/products/images/' . $product->image) }}"
                                                style="height: 200px; width: 100%;" alt="Category"></div>

                                        <div class="thumblist">
                                            <marquee direction="up" behavior="scroll" scrollamount="3"
                                                style="height: 200px;">
                                                @foreach ($product->variations as $variation)
                                                    <img class="mb-1"
                                                        src="{{ asset('storage/vendor/products/images/' . $variation->pivot->image) }}"
                                                        style=" width: auto; max-width: 100%;" alt="Category">
                                                @endforeach
                                            </marquee>
                                        </div>

                                    </div>
                                </a>
                                <div class="card-body text-center justify-content-center">
                                    <h5 class="text-truncate card-title">{{ $product->name }}</h5>
                                    <p class="text-muted">Starting from Rs.{{ $product->price }}/-</p>

                                    @php
                                        $totalReviews = 0;
                                        $count = 0;
                                        foreach ($product->reviews as $key => $review) {
                                            $totalReviews += $review->rating;
                                            $count += 1;
                                        }
                                        if (!($count < 1)) {
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


                                </div>
                            </div>
                        </div>
                    @endforeach



                </div>
                @if ($products->count() > 11 && !request()->routeIs('categoryPage'))
                    <div class="d-flex justify-content-center mb-3 mt-2">
                        <button id="load-more" data-skip="{{ count($products) }}" data-search="{{ $searchQuery }}"
                            class="btn btn-outline-warning" style="width:40%"><b>Load More</b></button>
                    </div>
                @endif
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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-more').on('click', function() {
                var skip = $(this).data('skip');
                var search = $(this).data('search');

                $.ajax({
                    url: "{{ route('loadMoreProducts') }}",
                    method: 'GET',
                    data: {
                        skip: skip,
                        search: search
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            response.forEach(function(product) {
                                var totalReviews = 0;
                                var count = product.reviews.length;

                                product.reviews.forEach(function(review) {
                                    totalReviews += review.rating;
                                });

                                if (count > 0) {
                                    totalReviews = totalReviews / count;
                                }
                                var totalReviews = Math.floor(totalReviews);
                                var emptyStars = 5 - totalReviews;
                                var reviewStars = '';

                                for (var i = 0; i < totalReviews; i++) {
                                    reviewStars +=
                                        '<li class="list-inline-item"><i class="bi bi-star-fill"></i></li>';
                                }
                                for (var i = 0; i < emptyStars; i++) {
                                    reviewStars +=
                                        '<li class="list-inline-item"><i class="bi bi-star"></i></li>';
                                }
                                $('#product-list').append(
                                    '<div class="col-md-3 col-sm-6 p-2">' +
                                    '<div class="card mb-30 border-0">' +
                                    '<a class="card-img-tiles" href="/productView/' +
                                    product.id + '" data-abc="true">' +
                                    '<div class="inner">' +
                                    '<div class="main-img">' +
                                    '<img src="/storage/vendor/products/images/' +
                                    product.image +
                                    '" style="height: 200px; width: 100%;" alt="Category">' +
                                    '</div>' +
                                    '<div class="thumblist">' +
                                    '<marquee direction="up" behavior="scroll" scrollamount="3" style="height: 200px;">' +
                                    product.variations.map(function(variation) {
                                        return '<img class="mb-1" src="/storage/vendor/products/images/' +
                                            variation.pivot.image +
                                            '" style="width: auto; max-width: 100%;" alt="Category">';
                                    }).join('') +
                                    '</marquee>' +
                                    '</div>' +
                                    '</div>' +
                                    '</a>' +
                                    '<div class="card-body text-center justify-content-center">' +
                                    '<h5 class="text-truncate card-title">' +
                                    product.name + '</h5>' +
                                    '<p class="text-muted">Starting from Rs.' +
                                    product.price + '/-</p>' +
                                    '<div class="star-rating">' +
                                    '<ul class="list-inline">' +
                                    reviewStars +
                                    '(' + count + ')' +
                                    '</ul>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>'
                                );
                            });

                            $('#load-more').data('skip', skip + response.length);
                        } else {
                            $('#load-more').text('No More Products').prop('disabled', true);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endif

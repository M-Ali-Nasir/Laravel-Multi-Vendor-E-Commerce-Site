@if (count($products) != 0)
    <figure class="text-center mt-5">
        <blockquote class="blockquote">
            <p>
                {{ $store['p-heading'] }}</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            {{ $store['p-subheading'] }}
        </figcaption>
    </figure>



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



    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Product Cards -->
                <div class="row">
                    <!-- Product Cards Here -->
                    <!-- Add more product cards as needed -->
                    @foreach ($products as $product)
                        <div class="col-md-3 col-sm-6 p-2">
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
                                <div class="card-body text-center">
                                    <h4 class="card-title">{{ $product->name }}</h4>
                                    <p class="text-muted">Starting from {{ $product->price }} PKR/-</p>
                                    <a class="btn btn-outline-primary btn-sm"
                                        href="{{ route('productView', ['product_id' => $product->id]) }}"
                                        data-abc="true">View Products</a>
                                </div>
                            </div>
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

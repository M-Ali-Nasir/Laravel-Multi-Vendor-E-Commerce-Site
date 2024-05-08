<!-- Hero 5 - Bootstrap Brain Component -->

@section('style')
    <style>
        .bsb-hero-5 {
            position: relative;
        }

        .bsb-hero-5::before {
            content: "";
            background: rgba(0, 0, 0, 0.5);
            /* Adjust the opacity to dim the background image */
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            /* Ensure the overlay is behind other content */
        }

        .container {
            position: relative;
            z-index: 2;
            /* Ensure content appears above the overlay */
        }
    </style>
@endsection


<section class="bsb-hero-5 px-3 py-5 bsb-overlay position-relative"
    style="background-image: url('{{ asset('storage/vendor/store/banner/' . $store->banner) }}'); background-size: cover;">
    <div class="container">
        <div class="row justify-content-md-center align-items-center">
            <div class="col-12 col-md-11 col-lg-9 col-xl-8 col-xxl-7">
                <h1 class="display-1 text-white text-center fw-bold mb-4">{{ $store->name }}</h1>
                <p class="lead text-white text-center mb-5 d-flex justify-content-sm-center">
                    <span class="col-12 col-sm-10 col-md-8 col-xxl-7"><strong>{{ $store->slogan }}</strong> <br>
                        {{ $store->description }}</span>
                </p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a type="button" href="#contactUs" class="btn bsb-btn-2xl btn-outline-light">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

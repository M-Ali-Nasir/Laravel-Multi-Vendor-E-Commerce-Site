@extends('index')

@section('style')

@endsection



@section('content')


    {{-- NAV BAR --}}
    <div class="bg-white py-3">

        <nav class="navbar navbar-expand-lg shadow-lg w-100 rounded-5" style="background-color:rgb(255, 255, 255)">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarExample"
                    aria-controls="navbarExample" aria-expanded="true" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/home/logo.png') }}"
                        width="40" /></a>
                <div class="collapse navbar-collapse" id="navbarExample">
                    <ul class="navbar-nav me-auto mb-0">
                        <li class="nav-item">
                            <a class="nav-link text-dark active" aria-current="page" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" aria-current="page" href="{{ route('allShopsPage') }}">Stores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" aria-current="page" href="{{ route('aboutPage') }}">About</a>
                        </li>

                        @if (request()->routeIs('ShopPage'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-dark" href="#"
                                    onclick="toggleDropdownCategory()" id="dropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                                <ul class="dropdown-menu" id="dropdownList">
                                    @foreach ($shopCategories as $category)
                                        <li><a class="dropdown-item text-dark"
                                                href="{{ route('categoryPage', ['id' => $category->id]) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach



                                </ul>
                            </li>
                        @endif
                    </ul>


                    <div class="d-flex align-items-center flex-column flex-lg-row">



                        @if (request()->routeIs('home') || request()->routeIs('ShopPage') || request()->routeIs('customerIndex'))
                            @include('components.home.serach')
                        @endif





                        @if (Session::has('customer'))
                            @include('components.home.customerNav')
                        @else
                            <div class="" style="">

                                @section('popupBtn', 'Sign-in')
                            @section('popupTitle', 'Sign-in As')
                            @section('popupContent')



                                <a class="dropdown-item" href="{{ route('customerLogin') }}">Customer</a>
                                <a class="dropdown-item" href="{{ route('vendorLogin') }}">Vendor</a>

                            @endsection
                            @include('components.home.popup')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

</div>






@yield('body')



{{-- @include('components.home.footer') --}}


@endsection

@section('javascript')

<script>
    function toggleDropdownCategory() {
        var ulElement = document.getElementById("dropdownList");
        if (ulElement.style.display == "block") {
            ulElement.style.display = "none";
        } else {
            ulElement.style.display = "block";
        }
        // Change "none" to "block", "inline", "flex", etc. as needed
    }

    function toggleDropdown() {
        var ulElement = document.getElementById("dropdown");
        if (ulElement.style.display == "block") {
            ulElement.style.display = "none";
        } else {
            ulElement.style.display = "block";
        }
        // Change "none" to "block", "inline", "flex", etc. as needed
    }

    document.addEventListener('click', function(event) {
        var dropdown = document.querySelector('.dropdown-menu');

        if (dropdown.style.display == "block") {
            dropdown.style.display = "none";
        }
    }, true);
    var dropdown = document.querySelector('.dropdown-menu');
    var dropdownToggle = document.querySelector('.dropdown');
    dropdownToggle.addEventListener('click', function(event) {
        if (dropdown.style.display == "block") {
            dropdown.style.display = "none";
        }
    }, true);
</script>

@endsection

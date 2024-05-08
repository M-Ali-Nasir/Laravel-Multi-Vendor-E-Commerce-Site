@extends('index')

@section('style')
    
@endsection



@section('content')


    {{-- NAV BAR --}}

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarExample"
                aria-controls="navbarExample" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/home/logo.png') }}"
                    width="100" /></a>
            <div class="collapse navbar-collapse" id="navbarExample">
                <ul class="navbar-nav me-auto mb-0">
                    <li class="nav-item">
                        <a class="nav-link text-dark active" aria-current="page" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" aria-current="page" href="{{ route('aboutPage') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" aria-current="page" href="{{ route('allShopsPage') }}">Shops</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="" onclick="toggleDropdownCategory()"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                        <ul class="dropdown-menu" id="dropdownList">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>


                <div class="d-flex align-items-center flex-column flex-lg-row">




                    @include('components.home.serach')



                    @if (Session::has('customer'))
                        @include('components.home.customerNav')
                    @else
                        @section('popupBtn', 'Sign-in')
                    @section('popupTitle', 'Sign-in As')
                    @section('popupContent')



                        <a class="dropdown-item" href="{{ route('customerLogin') }}">Customer</a>
                        <a class="dropdown-item" href="{{ route('vendorLogin') }}">Vendor</a>

                    @endsection
                    @include('components.home.popup')
                @endif
            </div>
        </div>
    </div>
</nav>



@yield('body')



@include('components.home.footer')


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
   
</script>

@endsection

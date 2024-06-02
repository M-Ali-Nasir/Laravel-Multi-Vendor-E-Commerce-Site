@extends('index')

@section('style')
@endsection



@section('content')
    {{-- NAV BAR --}}


    @include('components.home.navbar')


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

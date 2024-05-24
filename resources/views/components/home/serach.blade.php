{{-- <div class="container d-flex justify-content-center mb-3"> --}}
<form class="me-2 mb-2 mb-lg-0 d-flex me-5" method="GET" action="{{ route('home') }}">
    @csrf

    <div class="input-group rounded-5">
        <input type="text" class="form-control form-control-lg text-light" value="{{ $searchQuery }}"
            style="width: 200px; height:20px; background-color:rgba(255, 255, 255, 0.925);" placeholder="Search..."
            name="search" />
        <button class="btn btn-outline-warning" type="submit">
            <i class="bi bi-search"></i> <!-- Search icon -->
        </button>

    </div>


</form>

{{-- </div> --}}

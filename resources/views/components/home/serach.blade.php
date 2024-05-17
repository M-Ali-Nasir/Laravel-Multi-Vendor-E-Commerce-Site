<div class="container d-flex justify-content-center mb-3">
    <form class="me-2 mb-2 mb-lg-0 d-flex me-5" method="GET" action="{{ route('home') }}">
        @csrf
        <input type="text" class="form-control form-control-lg border-rounded -0" value="{{ $searchQuery }}"
            style="width: 500px;" placeholder="Search..." name="search" />
        <button class="btn btn-outline-success ms-1" type="submit">
            <i class="bi bi-search"></i> <!-- Search icon -->
        </button>
    </form>
</div>

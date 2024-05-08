
    <form class="me-2 mb-2 mb-lg-0 d-flex me-5" method="GET" action="@yield('search_action')">
        <input type="text" class="form-control form-control-sm" style="width: 250px;" placeholder="@yield('search_placeholder')" />
        <button class="btn btn-secondary" type="submit">
            <i class="bi bi-search"></i> <!-- Search icon -->
        </button>
    </form>

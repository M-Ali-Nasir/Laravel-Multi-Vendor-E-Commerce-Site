<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Add your custom styles here */
        .sidebar {
            height: 90vh;
            background-color: #dcdcdc;
            color: #343a40;
            padding-bottom: 50px;
            overflow-y: scroll;
        }

        body {
            max-height: 100vh;

        }

        .main {
            height: 90vh;
            overflow-y: auto;

        }

        .navbar {
            background-color: #343a40;
        }

        .vendor-name {
            color: #ffffff;
            font-weight: bold;
        }

        ::-webkit-scrollbar {
            width: 5px;
            /* Width of the scrollbar */
        }

        /* Track (the area around the thumb) */
        ::-webkit-scrollbar-track {
            margin-top: 15px;
            background: #f1f1f1;
            /* Color of the track */
        }

        /* Thumb (the draggable scrolling handle) */
        ::-webkit-scrollbar-thumb {
            background: transparent;
            /* Color of the thumb */
        }

        /* When hovering over the scrollbar */
        ::-webkit-scrollbar-thumb:hover {
            background: #848484;
            /* Color of the thumb on hover */
        }


        * {
            border: 0;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
    @yield('style')
</head>

<body>





    {{-- Loader ended --}}

    <div class="content" id="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-dark bg-dark rounded-bottom-5 shadow">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('vendorDashboard', ['vendorName' => $vendor->name]) }}">
                    <img src="{{ asset($vendor->avatar ? 'Storage/vendor/avatars/' . $vendor->avatar : 'Storage/vendor/avatars/default.png') }}"
                        alt="Vendor" width="30" height="30"
                        class="d-inline-block align-top rounded-circle me-2">
                    <span class="vendor-name">MarketPlace Connect</span>
                </a>
                <div class="d-flex">
                    <form action="{{ route('logoutVendor') }}" method="post">
                        @csrf
                        <button class="nav-link text-light btn"><i class="fas fa-sign-out me-2"></i>Sign-Out</button>
                    </form>
                </div>


            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-2 col-md-4 sidebar mt-2 rounded-end-5">
                    <div class="container text-center py-1">
                        @if (!empty($vendor->avatar))
                            <img src="{{ asset('Storage/vendor/avatars/' . $vendor->avatar) }}" alt="Vendor"
                                width="60" height="60" class="d-inline-block align-top rounded-circle me-2">
                        @else
                            <img src="{{ asset('Storage/vendor/avatars/default.png') }}" alt="Vendor" width="60"
                                height="60" class="d-inline-block align-top rounded-circle me-2">
                        @endif

                        <h4 class="my-1 text-dark text-center">{{ $vendor->name }}</h4>
                        <p class="text-dark">{{ $vendor->email }}</p>
                    </div>
                    <hr class="text-dark">

                    <ul class="nav flex-column">

                        <li class="nav-item rounded-4 {{ request()->routeIs('vendorDashboard') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('vendorDashboard') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('vendorDashboard', ['vendorName' => $vendor->name]) }}"><i
                                    class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                        </li>

                        <li class="nav-item rounded-4 {{ request()->routeIs('home') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('home') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('home') }}" target="_blank"><i class="fas fa-globe me-2"></i>Home
                                page</a>
                        </li>

                        <hr class="text-dark">


                        <li class="nav-item"><i class="fas fa-cog"></i>Settings:</li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('vendorProfile') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('vendorProfile') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('vendorProfile', ['vendorName' => $vendor->name]) }}"><i
                                    class="fas fa-user-cog me-2"></i>Profile Settings</a>
                        </li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('vendorStore') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('vendorStore') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('vendorStore', ['vendorName' => $vendor->name]) }}"><i
                                    class="fas fa-store me-2"></i>Store Settings</a>
                        </li>
                        {{-- <li class="nav-item">
                        <a class="nav-link text-dark"
                            href="{{ route('paymentPage', ['vendorName' => $vendor->name]) }}"><i
                                class="fas fa-hand-holding-usd me-2"></i>Payment Settings</a>
                    </li> --}}

                        <hr class="text-dark">


                        <li class="nav-item"><i class="fas fa-box-open"></i>Products:</li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('addProductPage') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('addProductPage') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('addProductPage', ['vendorName' => $vendor->name]) }}"><i
                                    class="fas fa-plus me-2"></i>Add New Products</a>
                        </li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('vendor.productList') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('vendor.productList') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('vendor.productList', ['id' => $vendor->id]) }}"><i
                                    class="fas fa-edit me-2"></i>View/Edit Products</a>
                        </li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('productCategories') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('productCategories') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('productCategories', ['id' => $vendor->id]) }}"><i
                                    class="fas fa-list me-2"></i>Product Categories</a>
                        </li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('productVariations') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('productVariations') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('productVariations', ['id' => $vendor->id]) }}"><i
                                    class="fas fa-cubes me-2"></i>Product Variations</a>
                        </li>
                        {{-- <li class="nav-item">
                        <a class="nav-link text-dark"
                            href="{{ route('inventoryManagementView', ['id' => $vendor->id]) }}"><i
                                class="fas fa-clipboard-list me-2"></i>Inventory Management</a>
                    </li> --}}

                        <hr class="text-dark">



                        <li class="nav-item"><i class="fas fa-shopping-cart"></i>Orders:</li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('orderDetails') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('orderDetails') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('orderDetails', ['id' => $vendor->id]) }}"><i
                                    class="fas fa-clipboard-check me-2"></i>Orders
                                Details</a>
                        </li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('orderHistory') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('orderHistory') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('orderHistory', ['id' => $vendor->id]) }}"><i
                                    class="fas fa-history me-2"></i>Orders
                                History</a>
                        </li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('vendorCustomers') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('vendorCustomers') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('vendorCustomers', ['id' => $vendor->id]) }}"><i
                                    class="fas fa-users me-2"></i>Customers</a>
                        </li>


                        <hr class="text-dark">


                        {{-- <li class="nav-item"><i class="fas fa-chart-line"></i>Sales Report:</li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#"><i class="fas fa-chart-bar me-2"></i>Sales
                            analytics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#"><i class="fas fa-history me-2"></i>Orders
                            History</a>
                    </li> --}}

                        <hr class="text-dark">


                        <li class="nav-item"><i class="fas fa-money-check-alt"></i>Payments:</li>
                        <li class="nav-item rounded-4 {{ request()->routeIs('paymentHistory') ? 'bg-dark' : '' }}">
                            <a class="nav-link {{ request()->routeIs('paymentHistory') ? 'text-light' : 'text-dark' }}"
                                href="{{ route('paymentHistory', ['id' => $vendor->id]) }}"><i
                                    class="fas fa-history me-2"></i>Payment
                                History</a>
                        </li>


                        <hr class="text-dark">






                        <li class="nav-item">
                            <form action="{{ route('logoutVendor') }}" method="post">
                                @csrf
                                <button class="nav-link text-dark btn"><i
                                        class="fas fa-sign-out me-2"></i>Sign-Out</button>
                            </form>
                        </li>
                        <!-- Add more sidebar items as needed -->
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="col-lg-10 col-md-8 main" style="background-color: #ffffff">
                    @yield('mainBody')
                </div>



                {{-- main content end --}}

            </div>
        </div>

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <!-- Custom Script -->

</body>

</html>

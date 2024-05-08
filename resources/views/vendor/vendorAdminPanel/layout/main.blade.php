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
      height: 100vh;
      background-color: #dcdcdc;
      color: #343a40;
      padding-bottom: 50px;
      overflow-y:scroll;
    }

    body{
      min-height: 100vh;
      
    }

    .main{
      height: 100vh;
      overflow-y: auto;
      
    }

    .navbar {
      background-color: #343a40;
    }

    .vendor-name {
      color: #ffffff;
      font-weight: bold;
    }

  </style>
  @yield('style')
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('vendorDashboard',['vendorName' => $vendor->name]) }}">
        <img src="vendor-pic.jpg" alt="Vendor" width="30" height="30"
          class="d-inline-block align-top rounded-circle me-2">
        <span class="vendor-name">MarketPlace Connect</span>
      </a>
      <div class="d-flex">
        <form class="d-flex me-4">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <a class="navbar-brand" href="#">
          <img src="vendor-pic.jpg" alt="Vendor" width="30" height="30"
            class="d-inline-block align-top rounded-circle me-2">

        </a>
      </div>


    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-2 col-md-4 sidebar">
        <div class="container text-center py-1">
          @if(!empty($vendor->avatar))
          <img src="{{ asset('Storage/vendor/avatars/'.$vendor->avatar) }}" alt="Vendor" width="60" height="60"
          class="d-inline-block align-top rounded-circle me-2">
            @else
            <img src="{{ asset('Storage/vendor/avatars/default.png') }}" alt="Vendor" width="60" height="60"
            class="d-inline-block align-top rounded-circle me-2">
            @endif
          
          <h4 class="my-1 text-dark text-center">{{ $vendor->name }}</h4>
          <p class="text-dark">{{$vendor->email}}</p>
        </div>
        <hr class="text-dark">

        <ul class="nav flex-column">
          
          <li class="nav-item">
            <a class="nav-link text-dark active" href="{{ route('vendorDashboard',['vendorName' => $vendor->name]) }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
          </li>

          <hr class="text-dark">


          <li class="nav-item"><i class="fas fa-cog"></i>Settings:</li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('vendorProfile',['vendorName' => $vendor->name]) }}"><i class="fas fa-user-cog me-2"></i>Profile Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('vendorStore',['vendorName' => $vendor->name]) }}"><i class="fas fa-store me-2"></i>Store Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('paymentPage',['vendorName' => $vendor->name]) }}"><i class="fas fa-hand-holding-usd me-2"></i>Payment Settings</a>
          </li>

          <hr class="text-dark">


          <li class="nav-item"><i class="fas fa-box-open"></i>Products:</li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('addProductPage',['vendorName' => $vendor->name]) }}"><i class="fas fa-plus me-2"></i>Add New Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('vendor.productList', ['id' => $vendor->id ]) }}"><i class="fas fa-edit me-2"></i>View/Edit Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('productCategories',['id' =>$vendor->id]) }}"><i class="fas fa-list me-2"></i>Product Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('productVariations',['id' =>$vendor->id]) }}"><i class="fas fa-cubes me-2"></i>Product Variations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="#"><i class="fas fa-clipboard-list me-2"></i>Inventory Management</a>
          </li>

          <hr class="text-dark">



          <li class="nav-item"><i class="fas fa-shopping-cart"></i>Orders:</li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="#"><i class="fas fa-clipboard-check me-2"></i>Orders Details</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="#"><i class="fas fa-file-alt me-2"></i>Manage Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="#"><i class="fas fa-users"></i>Customers</a>
          </li>


          <hr class="text-dark">


          <li class="nav-item"><i class="fas fa-chart-line"></i>Sales Report:</li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="#"><i class="fas fa-chart-bar me-2"></i>Sales analytics</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="#"><i class="fas fa-history me-2"></i>Orders History</a>
          </li>

          <hr class="text-dark">


          <li class="nav-item"><i class="fas fa-money-check-alt"></i>Payments:</li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="#"><i class="fas fa-history me-2"></i>Payment History</a>
          </li>
          
          
          <hr class="text-dark">
       





          <li class="nav-item">
            <form action="{{ route('logoutVendor') }}" method="post">
              @csrf
              <button class="nav-link text-dark btn"><i class="fas fa-sign-out me-2"></i>Sign-Out</button>
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

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Font Awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <!-- Custom Script -->
  <script>
    // Add your custom JavaScript here
  </script>
</body>

</html>
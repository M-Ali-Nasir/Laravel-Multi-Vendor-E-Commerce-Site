@extends('vendor.vendorAdminPanel.layout.main')

@section('title','Dashboard')

@section('mainBody')


    <div class="p-4">
        <h3>Welcome {{$vendor->name}} to your Dashboard</h3>
        <!-- Add your main content here -->
    </div>

    {{-- Order Details --}}

    <div class="mt-5">
        <h4>Orders Detail:</h4>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
          <div class="col-md-3 mb-1" >
            <div class="card text-center" style="background-color: #6da4e7">
              <div class="card-body">
                <i class="bi bi-cart4 fs-3"></i>
                <h5 class="card-title mt-3">Total Orders</h5>
                <p class="card-text">123</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-1">
            <div class="card text-center" style="background-color: #6de77b">
              <div class="card-body">
                <i class="bi bi-cart4 fs-3"></i>
                <h5 class="card-title mt-3">Completed Orders</h5>
                <p class="card-text">123</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-1">
            <div class="card text-center" style="background-color: #c4e76d">
              <div class="card-body">
                <i class="bi bi-cart4 fs-3"></i>
                <h5 class="card-title mt-3">Pending Orders</h5>
                <p class="card-text">123</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-1">
            <div class="card text-center" style="background-color: #e76d6d">
              <div class="card-body">
                <i class="bi bi-cart4 fs-3"></i>
                <h5 class="card-title mt-3">Canceled Orders</h5>
                <p class="card-text">123</p>
              </div>
            </div>
          </div>

        </div>
      </div>


      {{-- Revenue Details --}}

      <div class="mt-5">
        <h4>Revenue  Detail:</h4>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
          <div class="col-md-3 mb-1" >
            <div class="card text-center" style="background-color: #6da4e7">
              <div class="card-body">
                <i class="bi bi-cart4 fs-3"></i>
                <h5 class="card-title mt-3">Total Earning</h5>
                <p class="card-text">123</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-1">
            <div class="card text-center" style="background-color: #6de77b">
              <div class="card-body">
                <i class="bi bi-cart4 fs-3"></i>
                <h5 class="card-title mt-3">Recieved Payments</h5>
                <p class="card-text">123</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-1">
            <div class="card text-center" style="background-color: #c4e76d">
              <div class="card-body">
                <i class="bi bi-cart4 fs-3"></i>
                <h5 class="card-title mt-3">Pending Payments</h5>
                <p class="card-text">123</p>
              </div>
            </div>
          </div>
        </div>
      </div>




@endsection
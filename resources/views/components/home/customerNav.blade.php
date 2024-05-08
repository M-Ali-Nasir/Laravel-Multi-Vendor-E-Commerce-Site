<a class="btn" href="{{ route('customerCart', ['customerName' => $customer->name]) }}"><i class="bi bi-cart"></i>Cart</a>
<a class="btn" href="{{ route('customerProfile', ['customerName' => $customer->name]) }}"><i class="bi bi-person"></i>Account</a>
<a class="btn" href="{{ route('logoutCustomer') }}"><i class="bi bi-box-arrow-right"></i>Logout</a>
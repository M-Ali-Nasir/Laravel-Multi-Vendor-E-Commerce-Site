<a class="btn" href="{{ route('customerCart', ['customerName' => $customer->id]) }}"><i class="bi bi-cart"
        value={{ $cartAmount }}></i>Cart</a>

<a class="btn" href="{{ route('customerProfile', ['customerName' => $customer->id]) }}"><i
        class="bi bi-person"></i>Account</a>
<a class="btn" href="{{ route('logoutCustomer') }}"><i class="bi bi-box-arrow-right"></i>Logout</a>

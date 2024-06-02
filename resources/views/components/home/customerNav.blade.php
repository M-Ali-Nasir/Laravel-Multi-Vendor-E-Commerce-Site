<a class="btn text-dark" href="{{ route('customerCart', ['customerName' => $customer->id]) }}"><i class="bi bi-cart"
        value={{ $cartAmount }}></i>Cart</a>
<a class="btn text-dark" href="{{ route('trackOrders', ['id' => $customer->id]) }}"><i class="bi bi-geo-alt"
        value={{ $cartAmount }}></i>&nbsp;Track Orders</a>

<a class="btn text-dark" href="{{ route('customerProfile', ['customerName' => $customer->id]) }}"><i
        class="bi bi-person"></i> &nbsp;Account</a>
<a class="btn  text-dark" href="{{ route('logoutCustomer') }}"><i class="bi bi-box-arrow-right"></i>&nbsp;Logout</a>

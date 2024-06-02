 {{-- Slider --}}
 {{-- @php
 if (Session::has('customer')) {
     $layout = 'user.userHome';
 }else {
     $layout = 'user.userHome';
 }
@endphp --}}


 @extends('user.userHome')

 @section('title')
     {{ $product->name }}
 @endsection

 @section('style')
 @endsection

 @section('body')
     @include('components.productPage.productdetails')
 @endsection

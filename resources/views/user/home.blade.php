 {{-- Slider --}}
 @php
     if (Session::has('customer')) {
         $layout = 'user.userHome';
     } else {
         $layout = 'user.userHome';
     }
 @endphp


 @extends($layout)



 {{-- @section('search_action', "{{ route('home') }}") --}}

 @section('body')

     @include('components.home.serach')

 @section('title', 'MarketPlace-Connect')




 @include('components.home.slider')

 @php
     $totalSearch = count($products) + count($categories) + count($stores);
 @endphp

 @if ($totalSearch > 0)
     @if ($searchQuery)
         <div class="container mt-5 mb-5 d-flex justify-content-center">
             <h6>Search Results : {{ $totalSearch }}</h6>
         </div>
     @endif


     @include('components.home.categories')

     @include('components.home.topStores')

     @include('components.home.allProducts')
 @else
     @if ($searchQuery != '')
         <div class="container mt-5 mb-5 d-flex justify-content-center">
             <h6>Search Results : {{ $totalSearch }}</h6>
         </div>
     @endif
 @endif



 {{-- @include('components.home.subscribe') --}}


@endsection

 {{-- Slider --}}
@php
  if (Session::has('customer')) {
      $layout = 'user.userHome';
  }else {
      $layout = 'user.userHome';
  }
@endphp


@extends($layout)

@section('title', 'MarketPlace-Connect')

@section('search_placeholder','Search Products/Shops/Categories')

@section('search_action','#')

@section('body')


  @include('components.home.slider')

  @include('components.home.categories')

  @include('components.home.topStores')
  
  @include('components.home.allProducts')

  @include('components.home.subscribe')


@endsection
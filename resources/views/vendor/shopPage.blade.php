@extends('user.userHome')

@section('title', 'About')

@section('search_placeholder', 'Search Products/Categories')

@section('search_action', '#')

@section('body')


    <div class="container d-flex justify-content-center mb-3">
        <form class="me-2 mb-2 mb-lg-0 d-flex me-5" method="GET" action="{{ route('ShopPage', ['id' => $store->id]) }}">
            @csrf
            <input type="text" class="form-control form-control-lg border-rounded -0" value="{{ $searchQuery }}"
                style="width: 500px;" placeholder="Search..." name="search" />
            <button class="btn btn-outline-success ms-1" type="submit">
                <i class="bi bi-search"></i> <!-- Search icon -->
            </button>
        </form>
    </div>
    @include('components.home.shopbanner')


    @php
        $totalSearch = count($products) + count($categories);
    @endphp

    @if ($totalSearch > 0)
        @if ($searchQuery)
            <div class="container mt-5 mb-5 d-flex justify-content-center">
                <h6>Search Results : {{ $totalSearch }}</h6>
            </div>
        @endif




        @include('components.shoppage.categories')
        @include('components.shoppage.products')
    @else
        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <h6>Search Results : 0</h6>
        </div>
    @endif






    @include('components.shoppage.contact')

@endsection

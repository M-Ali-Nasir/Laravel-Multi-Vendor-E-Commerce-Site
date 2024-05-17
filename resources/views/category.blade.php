@extends('user.userHome')

@section('title', 'Category')





@section('body')

    @include('components.home.slider')

    {{-- <figure class="text-center mt-5">
        <blockquote class="blockquote">
            <p>{{ $category->Name }}</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            Explore Products of {{ $category->name }} Category
        </figcaption>
    </figure>

    <div class="container">
        <p>
            Welcome to MarketPlace Connect, where shopping meets convenience and variety. At MarketPlace
            Connect, we're passionate about bringing together a diverse array of vendors and shoppers in
            one dynamic platform. Our mission is to empower both sellers and buyers by providing a seamless,
            user-friendly experience that fosters growth and community. Whether you're a small business looking
            to expand your reach or a savvy shopper searching for unique products, MarketPlace Connect is your
            ultimate destination. Join us in creating a vibrant marketplace where connections are made,
            transactions are effortless, and shopping is an enjoyable adventure.
        </p>
    </div> --}}
    <h6 class="text-center mt-5 mb-3 text-decoration-underline">{{ $category->name }}</h6>
    @include('components.home.allProducts')


@endsection

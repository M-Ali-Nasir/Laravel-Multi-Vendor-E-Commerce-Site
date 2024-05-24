@extends('user.userHome')

@section('title', 'About')

@section('body')

    @include('components.home.slider')

    <figure class="text-center mt-5">
        <blockquote class="blockquote">
            <p>About MarketPlace Connect</p>
        </blockquote>
        <figcaption class="blockquote-footer">
            About MarketPlace Connect
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

    </div>


@endsection

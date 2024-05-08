@extends('index')

@section('title', 'About')


@section('content')


@include('components.home.shopbanner')

@include('components.shoppage.categories')
@include('components.shoppage.products')

@include('components.shoppage.contact')

@endsection
@extends('user.userHome')

@section('title', 'About')

@section('search_placeholder','Search Products/Categories')

@section('search_action','#')

@section('body')


@include('components.home.shopbanner')

@include('components.shoppage.categories')
@include('components.shoppage.products')

@include('components.shoppage.contact')

@endsection
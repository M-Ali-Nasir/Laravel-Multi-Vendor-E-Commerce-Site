 {{-- Slider --}}
 {{-- @php
 if (Session::has('customer')) {
     $layout = 'user.userHome';
 }else {
     $layout = 'user.userHome';
 }
@endphp


@extends($layout)

@section('title', 'Category Name')

@section('style')

@endsection

@section('body')

@include('components.categories.categoryProducts')


@endsection --}}

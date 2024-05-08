@extends('vendor.vendorAdminPanel.layout.main')

@section('title','Profile Setting')


@section('mainBody')




  @if(empty($store))

  <div class="text-center py-5 my-5">
    <i class="far fa-sad-tear" style="font-size: 5rem;"></i>
    <p class="lead">Oops! You don't have Store</p>
    <a href="{{ route('createStorePage',['vendorName' => $vendor->name ]) }}" class="btn btn-primary">Create a New</a>
  </div>

  @else


    <div class="container py-5">
        <div class="row">
          <div class="col">
            <nav aria-label="nav navbar" class="bg-light rounded-3 p-3 mb-4">
              <ol class="nav mb-0">
                <li class="nav-item me-4"><a class="btn text-primary" href="{{ route('editStorePage',['vendorName' => $vendor->name ]) }}"><i class="fas fa-pencil-alt me-1"></i>Edit Store</a></li>
                <li class="nav-item me-4"><a class="btn text-primary" href="{{ route('storePreview',['id'=> $store->id ]) }}"><i class="fas fa-expand me-1"></i>Full Screen Preview</a></li>
                <li class="nav-item me-4"><a class="btn text-danger" href="{{ route('deleteStore',['id'=> $store->id ]) }}"><i class="fas fa-trash-alt me-1"></i>Delete</a></li>
              </ol>
            </nav>
          </div>
        </div>
    
    @include('components.home.shopbanner')

    @include('components.shoppage.categories')
    @include('components.shoppage.products')
    
    @include('components.shoppage.contact')

    @endif


@endsection
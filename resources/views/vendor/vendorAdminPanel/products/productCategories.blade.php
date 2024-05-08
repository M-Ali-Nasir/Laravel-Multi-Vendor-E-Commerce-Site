@extends('vendor.vendorAdminPanel.layout.main')

@section('title','Product Categories')

@section('mainBody')


<div class="container">
    <div class="p-4 d-flex align-items-center">
        <h6>Add new Category</h6>
        <button class="btn btn-primary p-1 m-2" type="button" data-bs-toggle="modal" data-bs-target="#new">New</button>
        <!-- Add your main content here -->
    </div>

    <div class="modal fade" id="new" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{ route('createCategories',['id'=> $vendor->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create new category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form content -->

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="electronics" name="name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End Popup Form Modal -->
</div>


<table class="table table-striped">
    <thead>
        <tr>
            <th style="width: 10%;">Serial No</th>
            <th style="width: 40%;">Name</th>
            <th style="width: 30%;">Image</th>
            <th style="width: 20%;">Operations</th>
        </tr>
    </thead>
    <tbody>
        @if ($categories)
        @foreach ($categories as $key => $category)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$category->name}}</td>
            <td><img src="{{ asset('storage/vendor/products/category/images/'.$category->image)}}" alt="Image" style="max-width: 50px;"></td>
            <td>
                <button class="btn btn-primary p-1 m-1" type="button" data-bs-toggle="modal"
                    data-bs-target="#edit{{$category->id}}">Edit</button>


                <div class="modal fade" id="edit{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <form action="{{ route('editCategories',['id'=>$vendor->id, 'cat_id' => $category->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Form content -->
                                
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" value="{{$category->name}}"
                                            name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image" >
                                    </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                <!-- End Popup Form Modal -->
                </div>

                <a href="{{route('deleteCategories',['id' => $vendor->id, 'cat_id' => $category->id])}}" class="btn btn-danger m-1 p-1">Delete</a>
            </td>
        </tr>
        @endforeach
        @endif

        <!-- Add more rows as needed -->
    </tbody>
</table>
</div>




@endsection
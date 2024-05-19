@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Product Categories')

@section('mainBody')


    <div class="container">
        <div class="p-4 d-flex align-items-center">
            {{-- <h6>Add new variation</h6> --}}
            <button class="btn btn-primary p-1 m-2" type="button" data-bs-toggle="modal" data-bs-target="#new">Add
                new
                variation</button>
            <!-- Add your main content here -->
        </div>

        <div class="modal fade" id="new" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="{{ route('createVariation', ['id' => $vendor->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create new variation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form content -->

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Small-Red"
                                    name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="size" class="form-label">Size</label>
                                <input type="text" class="form-control" id="size" placeholder="Small"
                                    name="size">
                            </div>
                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="color" class="form-control" id="color" placeholder="Red" name="color">
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Wieght</label>
                                <input type="text" class="form-control" id="weight" placeholder="5kg" name="weight">
                            </div>
                            <div class="mb-3">
                                <label for="material" class="form-label">Material</label>
                                <input type="text" class="form-control" id="material" placeholder="Cotton"
                                    name="material">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
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
                <th style="width: 5%;">Sr.No</th>
                <th style="width: 25%;">Name</th>
                <th style="width: 10%;">Size</th>
                <th style="width: 10%;">Color</th>
                <th style="width: 10%;">Weight</th>
                <th style="width: 10%;">Material</th>
                {{-- <th style="width: 10%;">Image</th> --}}
                <th style="width: 20%;">Operations</th>
            </tr>
        </thead>
        <tbody>
            @if ($variations)
                @foreach ($variations as $key => $variation)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $variation->name }}</td>
                        <td>{{ $variation->size }}</td>
                        <td>{{ $variation->color }}</td>
                        <td>{{ $variation->weight }}</td>
                        <td>{{ $variation->material }}</td>
                        {{-- <td><img src="{{ asset('storage/vendor/products/variation/images/' . $variation->image) }}"
                                alt="Image" style="max-width: 50px;"></td> --}}
                        <td>
                            <button class="btn btn-primary p-1 m-1" type="button" data-bs-toggle="modal"
                                data-bs-target="#edit{{ $variation->id }}">Edit</button>


                            <div class="modal fade" id="edit{{ $variation->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <form
                                    action="{{ route('editVariation', ['id' => $vendor->id, 'var_id' => $variation->id]) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit variation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form content -->

                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name"
                                                        value="{{ $variation->name }}" name="name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="size" class="form-label">Size</label>
                                                    <input type="text" class="form-control" id="size"
                                                        value="{{ $variation->size }}" name="size">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="color" class="form-label">Color</label>
                                                    <input type="color" class="form-control" id="color"
                                                        value="{{ $variation->color }}" name="color">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="weight" class="form-label">Weight</label>
                                                    <input type="text" class="form-control" id="weight"
                                                        value="{{ $variation->weight }}" name="weight">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="material" class="form-label">Material</label>
                                                    <input type="text" class="form-control" id="material"
                                                        value="{{ $variation->material }}" name="material">
                                                </div>

                                                {{-- <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image" >
                                    </div> --}}

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- End Popup Form Modal -->
                            </div>

                            <a href="{{ route('deleteVariation', ['id' => $vendor->id, 'var_id' => $variation->id]) }}"
                                class="btn btn-danger m-1 p-1">Delete</a>
                        </td>
                    </tr>
                @endforeach
            @endif

            <!-- Add more rows as needed -->
        </tbody>
    </table>
    </div>




@endsection

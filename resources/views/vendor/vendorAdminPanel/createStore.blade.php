@extends('vendor.vendorAdminPanel.layout.main')

@section('title','Profile Setting')


@section('mainBody')




    <div class="col-lg-10 py-3">
        <div class="card mb-4">
            <div class="card-body">
                <form method="post" action="{{ route('createStore',['id' => $vendor->id ]) }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Active Details -->
                    <div class="mb-3">
                      <label for="store_name" class="form-label">Store Name</label>
                      <input type="text" class="form-control" id="store_name" value="" name="name">
                      @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Other Information -->
                    <div class="mb-3">
                      <label for="slogan" class="form-label">Slogan</label>
                      <input type="text" class="form-control" id="slogan" value="" name="slogan">
                      @error('slogan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" value="" name="description">
                        @error('description')
                              <div class="text-danger">{{ $message }}</div>
                          @enderror
                      </div>
                    <div class="mb-3">
                      <label for="phone" class="form-label">Phone Number</label>
                      <input type="tel" class="form-control" id="phone" value="" name="phone">
                      @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" value="" name="address">
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror    
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                          <!-- Days Input -->
                          <div class="mb-3 row">
                            <label for="startDay" class="col-sm-4 col-form-label">Opening Day</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="startDay" placeholder="e.g., Monday" name="openingDay">
                              @error('openingDay')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                            </div>
                          </div>
                          <!-- Time Input -->
                          <div class="mb-3 row">
                            <label for="startTime" class="col-sm-4 col-form-label">Opening Time</label>
                            <div class="col-sm-8">
                              <input type="time" class="form-control" id="startTime" name="openingTime">
                              @error('openingTime')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <!-- Days Input -->
                          <div class="mb-3 row">
                            <label for="endDay" class="col-sm-4 col-form-label">Closing Day</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="endDay" placeholder="e.g., Friday" name="closingDay">
                              @error('closingDay')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                            </div>
                          </div>
                          <!-- Time Input -->
                          <div class="mb-3 row">
                            <label for="endTime" class="col-sm-4 col-form-label">Closing Time</label>
                            <div class="col-sm-8">
                              <input type="time" class="form-control" id="endTime" name="closingTime">
                              @error('closingTime')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                            </div>
                          </div>
                        </div>
                      </div>


                    <div class="mb-3">
                        <label for="banner" class="form-label">Banner</label>
                        <input type="file" class="form-control" id="banner" name="banner">
                        @error('banner')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="productHeading" class="form-label">Products Heading</label>
                        <input type="text" class="form-control" id="productHeading" value="" name="productHeading">
                        @error('productHeading')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror    
                    </div>
                    <div class="mb-3">
                        <label for="productSubHeading" class="form-label">Products Sub-heading</label>
                        <input type="text" class="form-control" id="productSubHeading" value="" name="productSubHeading">
                        @error('productSubHeading')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror    
                    </div>
                    <div class="mb-3">
                        <label for="categoriesHeading" class="form-label">Categories Heading</label>
                        <input type="text" class="form-control" id="categoriesHeading" value="" name="categoriesHeading">
                        @error('categoriesHeading')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror    
                    </div>
                    <div class="mb-3">
                        <label for="categoriesSubHeading" class="form-label">Categories Sub-heading</label>
                        <input type="text" class="form-control" id="categoriesSubHeading" value="" name="categoriesSubHeading">
                        @error('categoriesSubHeading')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror    
                    </div>
                    
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Create Store</button>
                  </form>
            </div>
        </div>
    </div>
    



@endsection
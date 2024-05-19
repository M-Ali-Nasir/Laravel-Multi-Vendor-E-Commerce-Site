@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Profile Setting')


@section('mainBody')





    {{-- Order Details --}}

    <section>
        <div class="container py-5">

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            @if (!empty($vendor->avatar))
                                <img src="{{ asset('Storage/vendor/avatars/' . $vendor->avatar) }}" alt="avatar"
                                    class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
                            @else
                                <img src="{{ asset('Storage/vendor/avatars/default.png') }}" alt="avatar"
                                    class="rounded-circle img-fluid" style="width: 150px; height: 150px;">
                            @endif

                            <h5 class="my-3">{{ $vendor->name }}</h5>
                            <p class="text-muted mb-1">{{ $store ? $store->name : 'No store created yet' }}</p>
                            <p class="text-muted mb-4">{{ $store ? $store->slogan : 'Create your store' }}</p>
                            <div class=" justify-content-center mb-2">
                                @if ($vendor->status == 'inactive')
                                    <p class="text-warning p-0 m-0">Your account is inactive.</p>
                                    <p> Activate to make your store visible for customers</p>
                                    <a href="{{ route('activation', ['id' => $vendor->id]) }}"
                                        class="btn btn-outline-primary ms-1">Activate</a>
                                @elseif ($vendor->status == 'banned')
                                    <p class="text-danger m-0 p-0">Your account is banned</p>
                                @else
                                    <p class="text-success p-0 m-0">Active Vendor</p>
                                @endif
                            </div>
                            <a href="{{ route('vendor.facebook.connect') }}" class="btn btn-primary">Connect with facebook
                                page</a>
                        </div>
                    </div>

                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="post" action="{{ route('updateProfile', ['id' => $vendor->id]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <!-- Active Details -->
                                <div class="mb-3">
                                    <label for="activeEmail" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="activeEmail" value="{{ $vendor->email }}"
                                        readonly>
                                </div>
                                <!-- Other Information -->
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" value="{{ $vendor->name }}"
                                        name="name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" value="{{ $vendor->phone }}"
                                        name="phone">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="activeEmail" class="form-label">Status</label>
                                    <input type="email" class="form-control" id="activeEmail"
                                        value="{{ $vendor->status }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="fullName"
                                        value="{{ $vendor->address }}" name="address">
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Bio</label>
                                    <textarea type="text" class="form-control" id="fullName" name="bio">{{ $vendor->bio }}</textarea>
                                    @error('bio')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control" id="profilePicture" name="avatar">
                                    @error('avatar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


@endsection

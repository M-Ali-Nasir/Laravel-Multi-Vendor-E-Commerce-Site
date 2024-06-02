@extends('admin.adminPannel.layout.layout')

@section('title', 'Dashboard')

@section('mainBody')

    <div class="container mt-5 px-0">


        @if (Session::has('success'))
            <div class="d-flex align-text-center justify-content-center">
                <div class="col-md-4 alert alert-success alert-dismissible text center fade show">
                    <strong>Success!</strong> {{ Session::get('success') }}
                </div>
            </div>
        @endif

        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @if (isset($vendors))
                    @foreach ($vendors as $customer)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($customer->avatar ? 'Storage/vendor/avatars/' . $customer->avatar : 'images/default/user.png') }}"
                                        alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">{{ $customer->name }}</p>
                                        <p class="text-muted mb-0">{{ $customer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="fw-normal mb-1">{{ $customer->phone }}</p>
                            </td>
                            <td>
                                <p class="">{{ $customer->address }}</p>
                            </td>
                            <td>{{ $customer->status }}</td>
                            <td>
                                {{-- <button type="button" class="btn btn-link btn-sm btn-rounded">
                                    Edit
                                </button> --}}
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $customer->id }}">
                                    Edit Status
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{ $customer->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Change
                                                    {{ $customer->name }}'s status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                @if ($customer->status == 'active')
                                                    <a class="btn btn-warning me-3"
                                                        href="{{ route('admin.inactiveVendor', ['vendor_id' => $customer->id]) }}">Inactive
                                                        User</a>
                                                    <a class="btn btn-danger ms-3"
                                                        href="{{ route('admin.banVendor', ['vendor_id' => $customer->id]) }}">Ban
                                                        User</a>
                                                @elseif ($customer->status == 'inactive')
                                                    <a class="btn btn-success me-3"
                                                        href="{{ route('admin.activeVendor', ['vendor_id' => $customer->id]) }}">Active
                                                        User</a>
                                                    <a class="btn btn-danger ms-3"
                                                        href="{{ route('admin.banVendor', ['vendor_id' => $customer->id]) }}">Ban
                                                        User</a>
                                                @elseif ($customer->status == 'banned')
                                                    <a class="btn btn-success me-3"
                                                        href="{{ route('admin.activeVendor', ['vendor_id' => $customer->id]) }}">Active
                                                        User</a>
                                                    <a class="btn btn-warning me-3"
                                                        href="{{ route('admin.inactiveVendor', ['vendor_id' => $customer->id]) }}">Inactive
                                                        User</a>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>


@endsection

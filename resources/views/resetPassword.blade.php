@extends('index')

@section('content')
    <section class="bg-light p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xxl-11">

                    <div class="card border-light-subtle shadow-sm">
                        <div class="row g-0">

                            <div class="col-12 col-md-12 d-flex align-items-center justify-content-center">
                                <div class="col-12 col-lg-11 col-xl-10">
                                    <div class="card-body p-3 p-md-4 p-xl-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-5">
                                                    <div class="text-center mb-4">
                                                        <a href="{{ route('home') }}">
                                                            <img src="{{ asset('images/home/logo.png') }}"
                                                                alt="BootstrapBrain Logo" width="130" height="120">
                                                        </a>
                                                    </div>
                                                    <h2 class="h4 text-center">Password Reset</h2>
                                                    <h3 class="fs-6 fw-normal text-secondary text-center m-0">Provide the
                                                        new password.
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('resetPassword', ['id' => $user_id]) }}" method="post">
                                            @csrf
                                            <div class="row gy-3 overflow-hidden">
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="password" class="form-control" name="password"
                                                            id="password" placeholder="name@example.com" required>
                                                        <label for="password" class="form-label">New Password</label>
                                                        <input type="text" value="{{ $usertype }}" name="usertype"
                                                            hidden>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button class="btn btn-dark btn-lg" type="submit">Reset
                                                            Password</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-12">
                                                @if ($usertype == 'customer')
                                                    <div
                                                        class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                                                        <a href="{{ route('customerLogin') }}"
                                                            class="link-secondary text-decoration-none">Login</a>
                                                        <a href="{{ route('customerRegister') }}"
                                                            class="link-secondary text-decoration-none">Register</a>
                                                    </div>
                                                @else
                                                    <div
                                                        class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                                                        <a href="{{ route('vendorLogin') }}"
                                                            class="link-secondary text-decoration-none">Login</a>
                                                        <a href="{{ route('vendorRegistration') }}"
                                                            class="link-secondary text-decoration-none">Register</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

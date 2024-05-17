<!-- Password Reset 8 - Bootstrap Brain Component -->
@extends('index')

@section('content')
    <section class="bg-light p-3 p-md-4 p-xl-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xxl-11">

                    @if (Session::has('success'))
                        <div class="d-flex align-text-center justify-content-center">
                            <div class="col-md-4 alert alert-success alert-dismissible text center fade show">
                                <strong>Email Sent!</strong> {{ Session::get('success') }}
                            </div>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="d-flex align-text-center justify-content-center">
                            <div class="col-md-4 alert alert-danger alert-dismissible text center fade show">
                                <strong>Invalid Email!</strong> {{ Session::get('error') }}
                            </div>
                        </div>
                    @endif

                    <div class="card border-light-subtle shadow-sm">
                        <div class="row g-0">
                            <div class="col-12 col-md-6">
                                <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy"
                                    src="{{ asset('images/default/forgetpassword.jpg') }}"
                                    alt="Welcome back you've been missed!">
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
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
                                                        email address associated with your account to reset your password.
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <form
                                            action="@if ($user == 'customer') {{ route('forgetPasswordSendMail') }}
                                        @elseif($user == 'vendor')
                                            {{ route('vendorForgetPasswordSendMail') }} @endif"
                                            method="post">
                                            @csrf
                                            <div class="row gy-3 overflow-hidden">
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="email" class="form-control" name="email"
                                                            id="email" placeholder="name@example.com" required>
                                                        <label for="email" class="form-label">Email</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button class="btn btn-dark btn-lg" type="submit">Send
                                                            Email</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-12">
                                                @if ($user == 'customer')
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

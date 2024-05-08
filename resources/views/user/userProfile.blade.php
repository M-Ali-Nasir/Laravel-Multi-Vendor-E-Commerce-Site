@extends('user.userHome')

@section('title', 'My Account')

@section('style')
<style>
    .profile-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .profile-pic {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin: auto;
        margin-top: -75px;
        border: 5px solid #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .profile-heading {
        text-align: center;
        margin-top: 20px;
    }
</style>

@endsection

@section('body')

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card profile-card">
                    <img src="{{ asset($customer->profile_picture ? 'images/customers/'.$customer->profile_picture : 'images/default/user.png') }}" alt="Profile Picture" class="card-img-top profile-pic">
                    <div class="card-body">
                        <h2 class="card-title profile-heading">{{ $customer->name }}</h2>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="bi bi-envelope me-2"></i>{{$customer->email}}</li>
                            <li class="list-group-item"><i class="bi bi-phone me-2"></i>{{$customer->phone}}</li>
                            <li class="list-group-item"><i class="bi bi-geo me-2"></i>{{$customer->address}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
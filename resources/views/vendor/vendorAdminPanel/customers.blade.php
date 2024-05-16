@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Dashboard')

@section('mainBody')

    <div class="container">
        <h2>All Customers</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                        </tr>
                    @endforeach


                    <!-- Add more rows for other customers -->
                </tbody>
            </table>
        </div>
    </div>



@endsection

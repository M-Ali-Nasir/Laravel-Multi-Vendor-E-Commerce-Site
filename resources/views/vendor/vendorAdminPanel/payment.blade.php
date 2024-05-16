@extends('vendor.vendorAdminPanel.layout.main')

@section('title', 'Profile Setting')


@section('mainBody')



    @if (count($paymentMethods) == 0)

        <form action="{{ route('addPaymentMethod', ['id' => $vendor->id]) }}" method="post">
            @csrf
            <div class="text-center py-5 my-5">
                <i class="far fa-sad-tear" style="font-size: 5rem;"></i>
                <p class="lead">You don't have added any payment method for your customers</p>
                <div class="container" style="padding: 0 20%;">
                    <label for="paymentMethod" class="form-label">Choose a Payment Method:</label>
                    <select class="form-select" id="paymentMethod" name="paymentMethod">
                        <option value="" selected disabled>Select Payment Method</option>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                        <option value="Stripe">Stripe</option>
                        {{-- <option value="Jazzcash">JazzCash</option>
          <option value="Easypaisa">Easypaisa</option>
          <option value="Credit Card">Credit Card</option>
          <option value="Debit Card">Debit Card</option> --}}
                        <!-- Add more payment method options here -->
                    </select>
                    @error('paymentMethod')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <button class="btn btn-primary mt-3">Add payment
                    Method</button>
            </div>

        </form>
    @else
        <div class="container">
            <div>
                <form action="{{ route('addPaymentMethod', ['id' => $vendor->id]) }}" method="post">
                    @csrf
                    <div class="text-center py-2">
                        <div class="container" style="padding: 0 20%;">
                            <label for="paymentMethod" class="form-label">Add Payment Methods for your customers:</label>
                            <select class="form-select" id="paymentMethod" name="paymentMethod">
                                <option value="" selected disabled>Select Payment Method</option>
                                <option value="Cash on Delivery">Cash on Delivery</option>
                                <option value="Stripe">Stripe</option>
                                {{-- <option value="Jazzcash">JazzCash</option>
                                <option value="Easypaisa">Easypaisa</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Debit Card">Debit Card</option> --}}
                                <!-- Add more payment method options here -->
                            </select>
                            @error('paymentMethod')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <button class="btn btn-primary mt-3">Add payment
                            Method</button>
                    </div>

                </form>
            </div>
        </div>


        <hr>

        <div class="container py-3">

            <div class="d-flex row">
                <h4 class="py-2">Allowed Payment Methods:</h4>
                @foreach ($paymentMethods as $key => $method)
                    <div class="d-flex align-items-center col-md-4 mb-4">
                        <h5>{{ $key + 1 }} {{ $method->payment_method }}: </h5> &nbsp;
                        <a href="{{ route('removePaymentMethod', ['id' => $method->id]) }}"
                            class="text-decoration-none text-danger"><i class="fas fa-trash"></i>Remove</a>
                    </div>
                @endforeach
            </div>

            <hr>

            <h4 class="py-2">Bank Details:</h4>

            <form action="{{ route('saveBankDetails', ['id' => $vendor->id]) }}" method="post">
                @csrf


                <div class="row">
                    <div class="col-md-12">

                        <div class="row">



                            <div class="col-md-4 mb-4">
                                <label for="number" class="form-label">Bank Account Name:</label>
                                <input type="text" class="form-control" id="number" placeholder="Ali Nasir"
                                    value="{{ !empty($bankDetails) ? $bankDetails->account_name : '' }}" name="accountName">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="number" class="form-label">Bank account number:</label>
                                <input type="text" class="form-control" id="number" placeholder="730099999996"
                                    value="{{ !empty($bankDetails) ? $bankDetails->account_number : '' }}"
                                    name="accountNumber">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="number" class="form-label">Bank Name:</label>
                                <input type="text" class="form-control" id="number" placeholder="Mezan Bank"
                                    value="{{ !empty($bankDetails) ? $bankDetails->bank_name : '' }}" name="bankName">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="number" class="form-label">Branch Name:</label>
                                <input type="text" class="form-control" id="number" placeholder="Main Branch"
                                    value="{{ !empty($bankDetails) ? $bankDetails->branch_name : '' }}" name="branchName">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="number" class="form-label">Bank Identification Code(BIC) or Swift
                                    Code:</label>
                                <input type="text" class="form-control" id="number" placeholder="ABCDEFGHXXX"
                                    value="{{ !empty($bankDetails) ? $bankDetails->bic : '' }}" name="bic">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="number" class="form-label">International Bank Account Number(IBAN):</label>
                                <input type="text" class="form-control" id="number"
                                    placeholder="PK12ABCD1234567890123456"
                                    value="{{ !empty($bankDetails) ? $bankDetails->iban : '' }}" name="iban">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="number" class="form-label">Bank Address</label>
                                <input type="text" class="form-control" id="number"
                                    placeholder="123 Main Street, City, Country"
                                    value="{{ !empty($bankDetails) ? $bankDetails->bank_address : '' }}"
                                    name="bankAddress">
                            </div>



                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-secondary mx-2 py-2">Update</button>

            </form>


        </div>


    @endif






@endsection

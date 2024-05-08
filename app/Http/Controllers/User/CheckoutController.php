<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    //
    public function checkoutView(){
        if(Session::has('customer')){
            $customer = Session::get('customer');
            return view('user.checkout', compact('customer'));
        }
        else{
            return redirect()->route('customerLogin');
        }
    }
}

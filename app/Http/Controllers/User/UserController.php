<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User\Customer;
use App\Models\User\Cart;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Products\Product_categories;

class UserController extends Controller
{
    //show user Profile

    public function customerProfile(){
        if(Session::has('customer')){
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();
            return view('user.userProfile', compact('customer'));
        }
    }

    public function customerCart(){
        if(Session::has('customer')){
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();
            $userCart = Cart::where('customer_id', $customer->id)->get();
            $products = Product::with('paymentMethods')->get();
            $categories = Product_categories::all();
            return view('user.userCart', compact('customer','userCart','products','categories'));
        }
    }
}

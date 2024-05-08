<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Vendor\Store;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Products\Product_categories;
use App\Models\Vendor\Vendor;


class AuthController extends Controller
{
    // viewing the Authentication pages fro customer
    public function loginPage(){
        return view('user.userlogin');
    }

    public function registerPage(){
        return view('user.userregister');
    }

    //registering new customers

    public function registerUser(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6',
        ]);

        $user = new Customer();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        
        $user->save();
        return redirect('/login');
    }

    public function loginUser(Request $request){
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $validated['email'])->first();

        if ($customer && Hash::check($validated['password'], $customer->password)) {
            // Password is correct
            // Proceed with login...
            Session::put('customer', $customer);
            return redirect()->route('customerIndex',['customerName', $customer->name]);
            } elseif($customer) {
            // Password is incorrect
            // Handle invalid login...
            return redirect()->back()->withErrors(['error' => 'Invalid Password']);
        }
        return redirect()->back()->withErrors(['error' => 'Invalid Email']);

    }

    public function logoutUser(){
        if(Session::has('customer')){
            Session::forget('customer');
            return redirect()->route('home');
        }
        return redirect()->route('home');
    }

    public function customerIndex($customerName){
        if(Session::has('customer')){
            $customer = Session::get('customer');
            $stores = Store::all();
            $products = Product::with('variations','paymentMethods')->get();
            $categories = Product_categories::all();
            $vendors = Vendor::all();
            return view('user.home', compact('customer','stores','products','categories','vendors'));
        }else{
            return redirect()->route('home');
        }
    }
}

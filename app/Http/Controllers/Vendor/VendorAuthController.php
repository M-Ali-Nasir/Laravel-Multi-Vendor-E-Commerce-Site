<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class VendorAuthController extends Controller
{
    //
    public function loginPage(){
        return view('vendor.authentication.login');
    }

    public function registerPage(){
        return view('vendor.authentication.register');
    }

    public function registerVendor(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email',
            'password' => 'required|string|min:6',
        ]);

        $user = new Vendor();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        
        $user->save();
        return redirect()->route('vendorLogin');
    }

    public function loginVendor(Request $request){

        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $vendor = Vendor::where('email', $validated['email'])->first();

        if ($vendor && Hash::check($validated['password'], $vendor->password)) {
            // Password is correct
            // Proceed with login...
            Session::put('vendor', $vendor);
            return redirect()->route('vendorDashboard',['vendorName', $vendor->name]);
            } elseif($vendor) {
            // Password is incorrect
            // Handle invalid login...
            return redirect()->back()->withErrors(['error' => 'Invalid Password']);
        }
        return redirect()->back()->withErrors(['error' => 'Invalid Email']);
    }

    public function logoutVendor(){
        if(Session::has('vendor')){
            Session::forget('vendor');
            return redirect()->route('home');
        }
        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Vendor\Store;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Products\Product_categories;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorContact;

class HomeController extends Controller
{
    //

    public function home(){
        if(Session::has('customer')){
            $customer= Session::get('customer');
            
            return redirect()->route('customerIndex',['customerName' => $customer->name]);
        }else{
            $stores = Store::all();
            $categories = Product_categories::all();
            $products = Product::with('variations','paymentMethods')->get();
            $vendors = Vendor::all();
            return view('user.home', compact('stores','products','categories','vendors'));
        }
    }

    public function privayPolicy(){
        return view('privacyPolicy');
    }


    public function aboutPage()
    {
        if (Session::has('customer')) {
            $customer = Session::get('customer');
            return view('about', compact('customer'));
        } else {
            return view('about');
        }
    }

    public function allShopsPage()
    {
        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $stores = Store::all();
            return view('allShops', compact('customer','stores'));
        } else {
            $stores = Store::all();
            
            return view('allShops',compact('stores'));
        }
    }

    public function shopPage($id)
    {
        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $store = Store::where('id', $id)->first();
            $products = Product::where('store_id', $store->id)->with('paymentMethods','variations')->get();
            
            $vendor = Vendor::where('id', $store->vendor_id)->first();
            $categories = Product_categories::where('vendor_id', $vendor->id)->get();
            return view('vendor.shopPage', compact('customer','store','vendor','products','categories'));
        } else {
            $store = Store::where('id', $id)->first();
            $vendor = Vendor::where('id', $store->vendor_id)->first();
            $products = Product::where('store_id', $store->id)->with('paymentMethods','variations')->get();
            $categories = Product_categories::where('vendor_id', $vendor->id)->get();
            return view('vendor.shopPage', compact('store','vendor','products','categories'));
        }
    }

    public function contactVendor(Request $request, $id,  $vendor_id){

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $name = $validated['name'];
        $email = $validated['email'];
        $subject = $validated['subject'];
        $usermessage = $validated['message'];

        $vendor = Vendor::where('id', $vendor_id)->first();
        $toEmail = $vendor->email;
        Mail::to($toEmail)->send(new VendorContact($name , $email , $subject , $usermessage , $vendor));

        return redirect()->back()->with('success','Email sent Successfully');

    }
}

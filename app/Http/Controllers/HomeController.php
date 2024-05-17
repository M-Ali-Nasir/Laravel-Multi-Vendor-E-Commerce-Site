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
use App\Models\User\Customer;

class HomeController extends Controller
{
    //

    public function home(Request $request){
        // if(Session::has('customer')){
        //     $customer= Session::get('customer');
            
        //     return redirect()->route('customerIndex',['customerName' => $customer->name]);
        // }else{
        //     $stores = Store::all();
        //     $categories = Product_categories::all();
        //     $products = Product::with('variations','paymentMethods')->get();
        //     $vendors = Vendor::all();
        //     return view('user.home', compact('stores','products','categories','vendors'));
        // }
        $allcategories = Product_categories::all();

        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $searchQuery = $request->search;
            return redirect()->route('customerIndex', ['customerName' => $customer->id])->with('searchQuery', $searchQuery);
        } else {
            // Get the search query
            $searchQuery = $request->input('search');
            
            // Initialize the query builder for products
            $productsQuery = Product::with('variations', 'paymentMethods');

            $storesQuery = Store::query();
            $categoriesQuery = Product_categories::query();
            // If there's a search query, apply filters
            if ($searchQuery) {
                $productsQuery->where('name', 'like', '%' . $searchQuery . '%')->orWhere('description', 'like', '%' . $searchQuery . '%');
                $storesQuery->where('name', 'like', '%' . $searchQuery . '%')->orWhere('description', 'like', '%' . $searchQuery . '%');
                $categoriesQuery->where('name', 'like', '%' . $searchQuery . '%');
            }

            // Get the filtered or all products
            $products = $productsQuery->get();
            
            // Get all stores, categories, and vendors
            $stores = $storesQuery->get();
            $categories = $categoriesQuery->get();
            $vendors = Vendor::all();

            
            

            return view('user.home', compact('stores', 'products', 'categories', 'vendors', 'searchQuery','allcategories'));
        }
    }

    public function privayPolicy(){
        return view('privacyPolicy');
    }


    public function aboutPage()
    {
        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $allcategories = Product_categories::all();

            return view('about', compact('customer','allcategories'));
        } else {
            $allcategories = Product_categories::all();

            return view('about',compact('allcategories'));
        }
    }

    public function allShopsPage()
    {
        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $allcategories = Product_categories::all();
            $stores = Store::all();
            return view('allShops', compact('customer','stores','allcategories'));
        } else {
            $stores = Store::all();
            $allcategories = Product_categories::all();
            return view('allShops',compact('stores','allcategories'));
        }
    }

    public function shopPage(Request $request, $id)
    {
        // if (Session::has('customer')) {
        //     $customer = Session::get('customer');
        //     $store = Store::where('id', $id)->first();
        //     $products = Product::where('store_id', $store->id)->with('paymentMethods','variations')->get();
            
        //     $vendor = Vendor::where('id', $store->vendor_id)->first();
        //     $categories = Product_categories::where('vendor_id', $vendor->id)->get();
        //     return view('vendor.shopPage', compact('customer','store','vendor','products','categories'));
        // } else {
        //     $store = Store::where('id', $id)->first();
        //     $vendor = Vendor::where('id', $store->vendor_id)->first();
        //     $products = Product::where('store_id', $store->id)->with('paymentMethods','variations')->get();
        //     $categories = Product_categories::where('vendor_id', $vendor->id)->get();
        //     return view('vendor.shopPage', compact('store','vendor','products','categories'));
        // }

        
        $allcategories = Product_categories::all();
        // Fetch the store and vendor information
        $store = Store::where('id', $id)->first();
        $vendor = Vendor::where('id', $store->vendor_id)->first();

        // Get the search query
        $searchQuery = $request->input('search');

        // Initialize the query builders for products and categories
        $productsQuery = Product::where('store_id', $store->id)->with('paymentMethods', 'variations');
        $categoriesQuery = Product_categories::where('vendor_id', $vendor->id);

        // If there's a search query, apply filters
        if ($searchQuery) {
            $productsQuery->where(function($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                      ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });

            $categoriesQuery->where('name', 'like', '%' . $searchQuery . '%');
        }

        // Fetch the results
        $products = $productsQuery->get();
        $categories = $categoriesQuery->get();

        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();
        
            return view('vendor.shopPage', compact('customer', 'store', 'vendor', 'products', 'categories', 'searchQuery','allcategories'));
        }else{
            return view('vendor.shopPage', compact('store', 'vendor', 'products', 'categories', 'searchQuery','allcategories'));
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

    public function categoryPage($id){

        $allcategories = Product_categories::all();
        $category = Product_categories::where('id', $id)->first();
        $vendor = Vendor::where('id', $category->vendor_id)->first();

        $store = Store::where('vendor_id', $vendor->id)->first();
        $products = Product::where('store_id', $store->id)->where('cat_id', $category->id)->with('paymentMethods', 'variations')->get();

        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();
        
            return view('category', compact('category','customer', 'store', 'vendor', 'products','allcategories'));
        }else{
            return view('category', compact('category','store', 'vendor', 'products','allcategories'));
        }
    }
}

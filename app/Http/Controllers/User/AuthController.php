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
use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcomeEmail;
use App\Mail\ForgetPassword;
use App\Mail\PasswordRestSuccessful;
use Illuminate\Support\Facades\Crypt;
use App\Models\User\Cart as UserCart;


class AuthController extends Controller
{
    // viewing the Authentication pages fro customer
    public function loginPage(Request $request){
        
        if (isset($request->quantity)){

            $validated = $request->validate([
                'quantity' => 'required|min:1|max:10',
                'price' => 'required',
                'variation' => 'required'
            ]);
            $productData = $request->only(['quantity','variation','price','productId']);
            Session::put('productData',$productData);
        }
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

        //sending welcome email to user 

        $toEmail = $user->email;

        Mail::to($toEmail)->send(new UserWelcomeEmail($user));

        return redirect('/login');
    }

    public function loginUser(Request $request){
        
        //dd(Session::get('productData'));
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $validated['email'])->first();

        if ($customer && Hash::check($validated['password'], $customer->password)) {
            // Password is correct
            // Proceed with login...
            Session::put('customer', $customer);
            if(Session::has('productData')){
                $productData =  Session::get('productData');

                return redirect()->route('addToCart', ['customerId' => $customer->id, 'productId' => $productData['productId']]);
            }else{
                return redirect()->route('customerIndex',['customerName', $customer->id]);
            }
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

    public function customerIndex(Request $request, $customerName){
        if(Session::has('customer')){
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();

            $searchQuery = $request->input('search');

            
            
            $vendors = Vendor::where('status', 'active');

            $activeVendorIds = vendor::where('status', 'active')->pluck('id')->toArray();
            $storesIds = Store::whereIn('vendor_id', $activeVendorIds)->pluck('id')->toArray();
            // Retrieve orders for the vendor with pending status
            $storesQuery = Store::whereIn('vendor_id', $activeVendorIds);



            // Initialize the query builder for products
            $productsQuery = Product::with('variations', 'paymentMethods')->whereIn('store_id', $storesIds);

            
            $categoriesQuery = Product_categories::whereIn('vendor_id', $activeVendorIds);

            $allcategories = Product_categories::whereIn('vendor_id', $activeVendorIds)->get();
            // If there's a search query, apply filters
            if ($searchQuery) {
                $productsQuery->where('name', 'like', '%' . $searchQuery . '%');
                $storesQuery->where('name', 'like', '%' . $searchQuery . '%');
                $categoriesQuery->where('name', 'like', '%' . $searchQuery . '%');
            }

            // Get the filtered or all products
            $products = $productsQuery->get();
            
            // Get all stores, categories, and vendors
            $stores = $storesQuery->get();
            $categories = $categoriesQuery->get();

            $cartAmount =0;
            $totalcart = UserCart::where('customer_id', $customer->id)->get();
            foreach ($totalcart as $key => $number) {
                $cartAmount++;
            }

            return view('user.home', compact('customer','stores','products','categories','vendors', 'searchQuery','allcategories','cartAmount'));
        }else{
            return redirect()->route('home');
        }
    }

    public function userForgetPassword(){
        $user = "customer";
        return view('forgetPassword',compact('user'));
    }

    public function forgetPasswordSendMail(Request $request){

        $validated = $request->validate([
            'email' => 'required|email',
        ]);
        $user = Customer::where('email', $validated['email'])->first();
        if(isset($user)){
            $usertype = "customer";
            Mail::to($validated['email'])->send(new ForgetPassword($usertype, $user));
            return redirect()->back()->with('success',"Check your Inbox");
        }
        return redirect()->back()->with('error',"No user found with this email");

    }

    public function resetPassword(Request $request, $id){
        $validated = $request->validate([
            'password' => 'required',
        ]);

        if($request->usertype == "customer"){
            $user = Customer::where('id', $id)->first();
            $user->password = Hash::make($validated['password']);

            $user->save();
            Session::forget('resetRoute');

            Mail::to($user->email)->send(new PasswordRestSuccessful($user));

            return redirect()->route('customerLogin');
        }elseif ($request->usertype == "vendor") {
            $user = Vendor::where('id', $id)->first();
            $user->password = Hash::make($validated['password']);

            $user->save();
            Session::forget('resetRoute');

            Mail::to($user->email)->send(new PasswordRestSuccessful($user));

            return redirect()->route('vendorLogin');
        }
    }

    public function resetPasswordView($id , $usertype){

        $user_id = Crypt::decryptString($id);
        // Parse the data (assuming JSON format)
        $id = json_decode($user_id, true);

        $type = Crypt::decryptString($usertype);
        // Parse the data (assuming JSON format)
        $usertype = json_decode($type, true);
        if(Session::has('resetRoute')){
            $usertype = $usertype['usertype'];
            $user_id = $id['id'];
            return view('resetPassword',compact('user_id','usertype'));
        }
        return redirect()->route('home');
        
    }
}

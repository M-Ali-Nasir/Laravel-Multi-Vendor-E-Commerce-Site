<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Vendor\Store;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Products\Product_categories;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorContact;
use App\Models\User\Customer;
use App\Models\User\Cart;
use App\Models\Vendor\Order;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

    public function home(Request $request)
    {

        $allcategories = Product_categories::all();

        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $searchQuery = $request->input('search');
            return redirect()->route('customerIndex', ['customerName' => $customer->id])->with('searchQuery', $searchQuery);
        } else {
            // Get the search query
            $searchQuery = $request->input('search');

            if ($request->input('skip')) {
                $skip = $request->input('skip');
            } else {
                $skip = 0;
            }

            $take = 12;


            $vendors = Vendor::where('status', 'active');

            $activeVendorIds = vendor::where('status', 'active')->pluck('id')->toArray();

            $topVendorIds = Order::join('vendors', 'orders.vendor_id', '=', 'vendors.id')
                ->where('vendors.status', 'active') // Assuming the column 'is_active' indicates whether a vendor is active
                ->select('orders.vendor_id', DB::raw('count(orders.vendor_id) as total'))
                ->groupBy('orders.vendor_id')
                ->orderBy('total', 'desc')
                ->take(5)
                ->pluck('orders.vendor_id')
                ->toArray();

            //dd($topVendorIds);


            $storesQuery = Store::whereIn('vendor_id', $topVendorIds)
                ->orderByRaw("FIELD(vendor_id, " . implode(',', $topVendorIds) . ")");
            // Retrieve orders for the vendor with pending status
            $storeIds = $storesQuery->pluck('id')->toArray();
            //$storesQuery = Store::whereIn('vendor_id', $activeVendorIds);

            $productStoreIds =  Store::whereIn('vendor_id', $activeVendorIds)->pluck('id')->toArray();

            // Initialize the query builder for products
            $productsQuery = Product::whereIn('store_id', $productStoreIds)->with('variations', 'paymentMethods', 'reviews');


            $categoriesQuery = Product_categories::whereIn('vendor_id', $activeVendorIds);

            $allcategories = Product_categories::whereIn('vendor_id', $activeVendorIds)->get();
            // If there's a search query, apply filters
            if ($searchQuery) {
                $productsQuery->where('name', 'like', '%' . $searchQuery . '%');
                $storesQuery->where('name', 'like', '%' . $searchQuery . '%');
                $categoriesQuery->where('name', 'like', '%' . $searchQuery . '%');
            }

            //$productsQuery->orderBy('price', 'asc');
            // Get the filtered or all products
            $products = $productsQuery->skip($skip)->take($take)->get();

            // Get all stores, categories, and vendors
            $stores = $storesQuery->get();
            $categories = $categoriesQuery->get();

            //dd($stores);



            return view('user.home', compact('stores', 'products', 'categories', 'vendors', 'searchQuery', 'allcategories'));
        }
    }

    public function loadMoreProducts(Request $request)
    {
        $skip = $request->input('skip');
        $take = 12; // Number of products to load per request
        $searchQuery = $request->input('search');

        $activeVendorIds = Vendor::where('status', 'active')->pluck('id')->toArray();
        $topVendorIds = Order::join('vendors', 'orders.vendor_id', '=', 'vendors.id')
            ->where('vendors.status', 'active')
            ->select('orders.vendor_id', DB::raw('count(orders.vendor_id) as total'))
            ->groupBy('orders.vendor_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->pluck('orders.vendor_id')
            ->toArray();

        $storeIds = Store::whereIn('vendor_id', $topVendorIds)->pluck('id')->toArray();
        $productsQuery = Product::whereIn('store_id', $storeIds)->with('variations', 'paymentMethods', 'reviews');

        if ($searchQuery) {
            $productsQuery->where('name', 'like', '%' . $searchQuery . '%');
        }

        $productsQuery->orderBy('price', 'asc');
        $products = $productsQuery->skip($skip)->take($take)->get();

        return response()->json($products);
    }

    public function privayPolicy()
    {
        return view('privacyPolicy');
    }


    public function aboutPage()
    {
        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $allcategories = Product_categories::all();

            $cartAmount = 0;
            $totalcart = Cart::where('customer_id', $customer->id)->get();
            foreach ($totalcart as $key => $number) {
                $cartAmount++;
            }

            return view('about', compact('customer', 'allcategories', 'cartAmount'));
        } else {
            $allcategories = Product_categories::all();

            return view('about', compact('allcategories'));
        }
    }

    public function allShopsPage()
    {

        $vendors = Vendor::where('status', 'active');

        $activeVendorIds = vendor::where('status', 'active')->pluck('id')->toArray();
        $storesIds = Store::whereIn('vendor_id', $activeVendorIds)->pluck('id')->toArray();

        $allcategories = Product_categories::whereIn('vendor_id', $activeVendorIds)->get();
        $stores = Store::whereIn('vendor_id', $activeVendorIds)->get();

        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();

            $cartAmount = 0;
            $totalcart = Cart::where('customer_id', $customer->id)->get();
            foreach ($totalcart as $key => $number) {
                $cartAmount++;
            }
            return view('allShops', compact('customer', 'stores', 'allcategories', 'cartAmount'));
        } else {
            return view('allShops', compact('stores', 'allcategories'));
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
        $productsQuery = Product::where('store_id', $store->id)->with('paymentMethods', 'variations', 'reviews');
        $categoriesQuery = Product_categories::where('vendor_id', $vendor->id);

        // If there's a search query, apply filters
        if ($searchQuery) {
            $productsQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });

            $categoriesQuery->where('name', 'like', '%' . $searchQuery . '%');
        }

        // Fetch the results
        $products = $productsQuery->get();
        $categories = $categoriesQuery->get();

        $shopCategories = $categories;

        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();

            $cartAmount = 0;
            $totalcart = Cart::where('customer_id', $customer->id)->get();
            foreach ($totalcart as $key => $number) {
                $cartAmount++;
            }

            return view('vendor.shopPage', compact('customer', 'store', 'vendor', 'products', 'categories', 'searchQuery', 'cartAmount', 'allcategories', 'shopCategories'));
        } else {
            return view('vendor.shopPage', compact('store', 'vendor', 'products', 'categories', 'searchQuery', 'allcategories', 'shopCategories'));
        }
    }

    public function contactVendor(Request $request, $id,  $vendor_id)
    {

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
        Mail::to($toEmail)->send(new VendorContact($name, $email, $subject, $usermessage, $vendor));

        return redirect()->back()->with('success', 'Email sent Successfully');
    }

    public function categoryPage($id)
    {

        $allcategories = Product_categories::all();
        $category = Product_categories::where('id', $id)->first();
        $vendor = Vendor::where('id', $category->vendor_id)->first();

        $store = Store::where('vendor_id', $vendor->id)->first();
        $products = Product::where('store_id', $store->id)->where('cat_id', $category->id)->with('paymentMethods', 'variations')->get();

        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();

            $cartAmount = 0;
            $totalcart = Cart::where('customer_id', $customer->id)->get();
            foreach ($totalcart as $key => $number) {
                $cartAmount++;
            }

            return view('category', compact('category', 'customer', 'store', 'vendor', 'products', 'allcategories', 'cartAmount'));
        } else {
            return view('category', compact('category', 'store', 'vendor', 'products', 'allcategories'));
        }
    }

    public function contactUsMail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $fromEmail = $validated['email'];
        $toEmail = 'marketplaceconnectofficial@gmail.com';
        Mail::to($toEmail)->send(new ContactUs($validated));

        return redirect()->back()->with('success', 'Email Sent Successfully');
    }
}

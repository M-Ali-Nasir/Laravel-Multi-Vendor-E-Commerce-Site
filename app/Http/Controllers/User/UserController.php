<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User\Customer;
use App\Models\User\Cart;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Products\Product_categories;
use App\Models\User\OrderAddress;
use App\Models\Vendor\Order;
use App\Models\Vendor\OrderHistory;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    //show user Profile

    public function customerProfile($id){
        if(Session::has('customer')){
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();
            $orders = Order::where('customer_id', $customer->id)->get();

            $products = new Collection();
            foreach($orders as $order){
                $product = Product::where('id', $order->product_id)->first();

                $products->add($product);
            }
            return view('user.userProfile', compact('customer','orders','products'));
        }
    }

    public function updateCustomerProfile(Request $request, $id){
        if(Session::has('customer')){
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();
           
            $validated = $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'bio' => 'required',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);

            $customer->name = $validated['name'];
            $customer->phone = $validated['phone'];
            $customer->address = $validated['address'];
            $customer->bio = $validated['bio'];

            if ($request->hasFile('avatar')) {
                // Delete previous profile picture if exists
                if (isset($customer->avatar)) {
                    Storage::delete('public/customer/avatars/'.$customer->avatar);
                }
    
                // Upload new profile picture
                $profilePic = $request->file('avatar');
                $fileName = time() . '_' . $profilePic->getClientOriginalName();
                $profilePic->storeAs('public/customer/avatars', $fileName);
    
                // Update vendor's profile picture in the database
                $customer->avatar = $fileName;
            }

            $customer->save();

            return redirect()->route('customerProfile',['customerName', $customer->id]);

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

    public function addShippingBillingAddress(Request $request, $id){
        if(Session::has('customer')){
            $customer = Customer::where('id', $id)->first();
            $cartItems = Cart::where('customer_id', $customer->id)->get();

            if($request->paymentmethod == "COD"){

                $orderaddressids = [];

                foreach($cartItems as $item){

                    $orderAddress = new OrderAddress();
                
                    // $validated = $request->validate([
                    //     'sphone' => 'required',
                    //     'sAddress' => 'required',
                    //     'sCountry' => 'required',
                    //     'sState' => 'required',
                    //     'sZip' => 'required',
                    // ]);
                    $orderAddress->shipping_phone = $request->sPhone;
                    $orderAddress->shipping_address = $request->sAddress;
                    $orderAddress->shipping_country = $request->sCountry;
                    $orderAddress->shipping_state = $request->sState;
                    $orderAddress->shipping_zip = $request->sZip; 

                    $customerShippingAddress = $request->sAddress . ', ' . $request->sState . ', ' . $request->sCountry . ' ' . $request->sZip;

                    $customer->shipping_address = $customerShippingAddress;
                        //dd($request->has('sameBilling'));
                    if($request->has('sameBilling')){

                        $orderAddress->billing_phone = $request->sPhone;
                        $orderAddress->billing_address = $request->sAddress;
                        $orderAddress->billing_country = $request->sCountry;
                        $orderAddress->billing_state = $request->sState;
                        $orderAddress->billing_zip = $request->sZip;

                        $customerBillingAddress = $request->sAddress . ', ' . $request->sState . ', ' . $request->sCountry . ' ' . $request->sZip;

                        $customer->billing_address = $customerBillingAddress;

                    }else{

                        // $request->validate([
                        //     'bphone' => 'required',
                        //     'bAddress' => 'required',
                        //     'bCountry' => 'required',
                        //     'bState' => 'required',
                        //     'bZip' => 'required',
                        // ]);

                        $orderAddress->billing_phone = $request->bPhone;
                        $orderAddress->billing_address = $request->bAddress;
                        $orderAddress->billing_country = $request->bCountry;
                        $orderAddress->billing_state = $request->bState;
                        $orderAddress->billing_zip = $request->bZip;

                        $customerBillingAddress = $request->bAddress . ', ' . $request->bState . ', ' . $request->bCountry . ' ' . $request->bZip;

                        $customer->billing_address = $customerBillingAddress;
                    
                    }

                    $orderAddress->customer_id = $customer->id;
                    $customer->save();
                    $orderAddress->save();

                    array_push($orderaddressids, $orderAddress->id);

                
                    
                }
                


                
               $orderids = [];

                foreach($cartItems as $item){
                    $newOrder = new Order();
                    $newOrder->vendor_id = $item->vendor_id;
                    $newOrder->customer_id = $item->customer_id;
                    $newOrder->product_id = $item->product_id;
                    $newOrder->variation_id = $item->variation_id;
                    $newOrder->quantity = $item->quantity;
                    $newOrder->payment_method = 'Cash on Delivery';
                    $newOrder->amount = $item->price * $item->quantity;

                    $newOrder->save();

                    $orderHistory = new OrderHistory();
                    $orderHistory->order_id = $newOrder->id;
                    $orderHistory->status = "Pending";
                    $orderHistory->save();

                    array_push($orderids, $newOrder->id);

                }

                
                foreach($orderaddressids as $key=>$address){
                    $address = OrderAddress::where('id', $address)->first();
        
                    $address->order_id = $orderids[$key];
                    $address->save();
        
                }


                Cart::where('customer_id', $customer->id)->delete();
                return redirect()->route('customerCart',['customerName' => $customer->name])->with('success','Payment Successful');
            }else{

                $addressIds = [];

                foreach($cartItems as $item){

                    $orderAddress = new OrderAddress();
                
                    // $validated = $request->validate([
                    //     'sphone' => 'required',
                    //     'sAddress' => 'required',
                    //     'sCountry' => 'required',
                    //     'sState' => 'required',
                    //     'sZip' => 'required',
                    // ]);
                    $orderAddress->shipping_phone = $request->sPhone;
                    $orderAddress->shipping_address = $request->sAddress;
                    $orderAddress->shipping_country = $request->sCountry;
                    $orderAddress->shipping_state = $request->sState;
                    $orderAddress->shipping_zip = $request->sZip; 

                    $customerShippingAddress = $request->sAddress . ', ' . $request->sState . ', ' . $request->sCountry . ' ' . $request->sZip;

                    $customer->shipping_address = $customerShippingAddress;
                        //dd($request->has('sameBilling'));
                    if($request->has('sameBilling')){

                        $orderAddress->billing_phone = $request->sPhone;
                        $orderAddress->billing_address = $request->sAddress;
                        $orderAddress->billing_country = $request->sCountry;
                        $orderAddress->billing_state = $request->sState;
                        $orderAddress->billing_zip = $request->sZip;

                        $customerBillingAddress = $request->sAddress . ', ' . $request->sState . ', ' . $request->sCountry . ', ' . $request->sZip;

                        $customer->billing_address = $customerBillingAddress;

                    }else{

                        // $request->validate([
                        //     'bphone' => 'required',
                        //     'bAddress' => 'required',
                        //     'bCountry' => 'required',
                        //     'bState' => 'required',
                        //     'bZip' => 'required',
                        // ]);

                        $orderAddress->billing_phone = $request->bPhone;
                        $orderAddress->billing_address = $request->bAddress;
                        $orderAddress->billing_country = $request->bCountry;
                        $orderAddress->billing_state = $request->bState;
                        $orderAddress->billing_zip = $request->bZip;

                        $customerBillingAddress = $request->bAddress . ', ' . $request->bState . ', ' . $request->bCountry . ' ' . $request->bZip;

                        $customer->billing_address = $customerBillingAddress;
                    
                    }

                    $orderAddress->customer_id = $customer->id;
                    $customer->save();
                    $orderAddress->save();
                    //dd($orderAddress);
                    //$orderAddressId = $orderAddress->getKey();
                    array_push($addressIds, $orderAddress->id);
                    
                }
                //dd($addressIds);
                $ids = json_encode($addressIds);
                return redirect()->route('stripe.checkout',['id' => $customer->id, 'orderAddress' => $ids]);
            }
            
            return redirect()->route('customerCart',['customerName' => $customer->name])->with('error','Order Failed Due to some reason');

            

            
        }
    }

   
}

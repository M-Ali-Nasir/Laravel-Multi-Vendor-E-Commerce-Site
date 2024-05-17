<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Customer;
use App\Models\User\Cart as UserCart;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Store;
use App\Models\Vendor\Products\Variations;
use Illuminate\Support\Facades\Session;


class Cart extends Controller
{
    //Add products to cart
    public function addToCart(Request $request, $customerId, $productId){
        // echo($customerId);
        // echo($productId);
        // echo($request->quantity);
        $product = Product::where('id', $productId)->first();
        $store = Store::where('id', $product->store_id)->first();
        $vendor = Vendor::where('id', $store->vendor_id)->first();
        
        $validated = $request->validate([
            'quantity' => 'required|min:1|max:10',
            'price' => 'required',
            'variation' => 'required'
        ]);
        $customer = UserCart::where('id', $customerId)->first();
        // if(empty($customer)){
            $cart = new UserCart();

            $cart->customer_id = $customerId;
            $cart->product_id = $productId;
            $cart->vendor_id = $vendor->id;
            $cart->quantity = $validated['quantity'];
            $cart->price = $validated['price'];
            $cart->variation_id = $request->variation;

            $cart->save();

            return redirect()->back()->with('success','Product Added Successfully');

        // }else{
        //     echo($customer);
        //     echo($request);
        // }
    }

    public function deleteCartItem($id, $item_id){
        if(session::has('customer')){
            $customer = Customer::where('id', $id)->first();
            $cartItem = UserCart::where('id', $item_id)->first();
            $cartItem->delete();

            return redirect()->route('customerCart',['customerName',$customer->id])->with('success','Item removed from cart successfully');
        }
    }
}

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
    public function addToCart(Request $request, $customerId, $productId)
    {
        // echo($customerId);
        // echo($productId);
        // echo($request->quantity);
        $product = Product::where('id', $productId)->first();
        $store = Store::where('id', $product->store_id)->first();
        $vendor = Vendor::where('id', $store->vendor_id)->first();

        if (Session::has('productData')) {
            //$productData = json_decode(json_encode(Session::get('productData')));
            $validated = Session::get('productData');
            //dd($validated);
        } else {
            $validated = $request->validate([
                'quantity' => 'required|min:1|max:10',
                'price' => 'required',
                'variation' => 'required'
            ]);
        }
        $customer = UserCart::where('id', $customerId)->first();
        // if(empty($customer)){
        $cart = new UserCart();

        $cart->customer_id = $customerId;
        $cart->product_id = $productId;
        $cart->vendor_id = $vendor->id;
        $cart->quantity = $request->quantity;
        $cart->price = $request->price;
        $cart->variation_id = $request->variation;

        $cart->save();

        Session::forget('productData');

        return redirect()->back()->with('success', 'Product Added Successfully');

        // }else{
        //     echo($customer);
        //     echo($request);
        // }
    }

    public function deleteCartItem($id, $item_id)
    {
        if (session::has('customer')) {
            $customer = Customer::where('id', $id)->first();
            $cartItem = UserCart::where('id', $item_id)->first();
            $cartItem->delete();

            return redirect()->route('customerCart', ['customerName', $customer->id])->with('success', 'Item removed from cart successfully');
        }
    }

    public function deleteCart($id)
    {
        if (Session::has('customer')) {
            UserCart::where('customer_id', $id)->delete();
            return redirect()->route('customerCart', ['customerName' => $id]);
        } else {
            return redirect()->route('home');
        }
    }
}

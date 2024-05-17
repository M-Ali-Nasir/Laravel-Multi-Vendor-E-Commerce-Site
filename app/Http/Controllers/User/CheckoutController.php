<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User\Customer;
use App\Models\User\Cart;
use App\Models\Vendor\Products\Product;
use Stripe;
use Illuminate\Support\Facades\Http;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Store;
use App\Models\Vendor\Products\variations;
use App\Models\User\OrderAddress;
use App\Models\Vendor\Order;
use App\Models\Vendor\OrderHistory;
use App\Mail\UserOrderDone;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorOrderRecieved;
use App\Models\Vendor\Products\Product_categories;


class CheckoutController extends Controller
{
    //
    public function checkoutView(){
        if(Session::has('customer')){

            $allcategories = Product_categories::all();

            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();
            $orderAddress = OrderAddress::where('customer_id', $customer->id)->first();
            return view('user.checkout', compact('customer','orderAddress','allcategories'));
        }
        else{
            return redirect()->route('customerLogin');
        }
    }


    


    public function stripeCheckout($id, $orderAddress){
        $customer = Customer::where('id', $id)->first();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $cartItems = Cart::where('customer_id', $customer->id)->get();

        

        $redirectUrl = route('stripe.checkout.success', ['customerId' => $customer->id, 'orderAddress' => $orderAddress]).'?session_id={CHECKOUT_SESSION_ID}';

        // $response = $stripe->checkout->sessions->create([
        //     'success_url' => $redirectUrl,
            
        //     'customer_email' => $customer->email,
            
        //     'payment_method_types' => ['link','card'],

        //     'line_items' => [
        //         [
        //             'price_data' =>[
        //                 'product_data' =>[
        //                     'name' => $request->product,
        //                 ],
        //                 'unit_amount' => 278.17 * $request->price,
        //                 'currency' => 'USD',
        //             ],
        //             'quantity' => 1,
        //         ],

        //     ],
        //     'mode' => 'payment',
        //     'allow_promotion_codes' => false,
        // ]);

        $response = $stripe->checkout->sessions->create([
            'success_url' => $redirectUrl,
            'customer_email' => $customer->email,
            'payment_method_types' => ['link','card'],
            'line_items' => collect($cartItems)->map(function ($cartItem) {
                $product = Product::findOrFail($cartItem->product_id);
                
                $converter = new CurrencyConverter();
                $price = round($converter->convertPKRtoUSD($cartItem->price) *100);
                return [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => $price, // Convert price to cents
                        'product_data' => [
                            'name' => $product->name,
                        ],
                    ],
                    'quantity' => $cartItem->quantity,
                ];
            })->toArray(),
            'mode' => 'payment',
            'allow_promotion_codes' => false,
        ]);
         

        
        


        return redirect($response['url']);
    }

    public function stripeCheckoutSuccess(Request $request){
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $customer = Customer::where('id', $request->customerId)->first();

        // $sessionId = $request->query('session_id');
        // //dd($request);
        // if (!isset($sessionId) || empty(trim($sessionId))) {
        //     // Handle the case where the session ID is null or empty
        //     return redirect()->route('customerCart',['customerName' => $customer->name])->with('error','Payment Successful: but something went wrong your order is not fullfilled');

        // } else {
        //     // Proceed with retrieving the checkout session using the validated session ID
        //     $response = $stripe->checkout->sessions->retrieve($sessionId);
        // }
        $string = $request->orderAddress;
        
        // Extract the array [19, 20]
        if (preg_match('/^\[(.*?)\]/', $string, $matches)) {
            $orderAddresses = json_decode('[' . $matches[1] . ']', true);
            
        }

        // Extract the session_id
        if (preg_match('/session_id=([^&]+)/', $string, $matches)) {
            $sessionId = $matches[1];
             // Output: cs_test_b1KvbHb6xbg2Qiy3ERfpse3fIc6urZWzugc2agrJej3FXRAMi6nDa2gMhx
        }
        

        $response = $stripe->checkout->sessions->retrieve($sessionId);

        //$customerId = $request->query('customerId');
       

        $cartItems = Cart::where('customer_id', $customer->id)->get();

        $orderIds = [];
        foreach($cartItems as $item){
            $product = Product::where('id', $item->product_id)->with('variations')->first();
            $variationId = $item->variation_id; // Replace this with the actual ID of the variation
            foreach ($product->variations as $variation) {

                if($variation->id == $variationId){
                    $newQuantity = $variation->pivot->quantity-$item->quantity;
                }
                
            }
            
            // Update the quantity for the specified variation
            $product->variations()->updateExistingPivot($variationId, ['quantity' => $newQuantity]);

            //adding into orders

            $newOrder = new Order();
            $newOrder->vendor_id = $item->vendor_id;
            $newOrder->customer_id = $item->customer_id;
            $newOrder->product_id = $item->product_id;
            $newOrder->variation_id = $item->variation_id;
            $newOrder->quantity = $item->quantity;
            $newOrder->payment_method = 'Card';
            $newOrder->amount = $item->price * $item->quantity;

            $newOrder->save();

            $orderHistory = new OrderHistory();
            $orderHistory->order_id = $newOrder->id;
            $orderHistory->status = "Pending";
            $orderHistory->save();

            array_push($orderIds, $newOrder->id); 


            $product = Product::where('id', $newOrder->product_id)->first();
            $toEmail = $customer->email;
            Mail::to($toEmail)->send(new UserOrderDone($customer, $newOrder, $product));
            $vendor = Vendor::where('id', $newOrder->vendor_id)->first();
            $toEmail = $vendor->email;
            Mail::to($toEmail)->send(new VendorOrderRecieved($customer, $newOrder, $product, $vendor));


        }


        //$orderAddresses = json_decode($request->orderAddress);

        

        foreach($orderAddresses as $key=>$address){
            $address = OrderAddress::where('id', $address)->first();

            $address->order_id = $orderIds[$key];
            $address->save();

        }
        

        
        
        
        Cart::where('customer_id', $customer->id)->delete();


        return redirect()->route('customerCart',['customerName' => $customer->name])->with('success','Payment Successful');

    }

    
}

class CurrencyConverter
{
//convert currency for payment

    public function convertPKRtoUSD($amountInPKR)
    {
        $response = Http::get('https://v6.exchangerate-api.com/v6/f1ff7ee9518b75bc6c963583/latest/PKR');

        if ($response->successful()) {
            $exchangeRates = $response->json()['conversion_rates'];

            // Check if USD exchange rate is available
            if (isset($exchangeRates['USD'])) {
                $exchangeRateUSD = $exchangeRates['USD'];
                $amountInUSD = $amountInPKR * $exchangeRateUSD ;
                
                return $amountInUSD;

            }
        }

        return null;
    }

}

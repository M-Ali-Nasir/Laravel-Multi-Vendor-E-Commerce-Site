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

class CheckoutController extends Controller
{
    //
    public function checkoutView(){
        if(Session::has('customer')){
            $customer = Session::get('customer');
            return view('user.checkout', compact('customer'));
        }
        else{
            return redirect()->route('customerLogin');
        }
    }


    


    public function stripeCheckout($id){
        $customer = Customer::where('id', $id)->first();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $cartItems = Cart::where('customer_id', $customer->id)->get();

        

        $redirectUrl = route('stripe.checkout.success', ['customerId' => $customer->id]).'?session_id={CHECKOUT_SESSION_ID}';

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
        

        $response = $stripe->checkout->sessions->retrieve($request->session_id);

        //$customerId = $request->query('customerId');
        $customer = Customer::where('id', $request->customerId)->first();

        $cartItems = Cart::where('customer_id', $customer->id)->get();

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

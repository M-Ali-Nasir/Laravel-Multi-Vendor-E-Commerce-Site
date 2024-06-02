<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Store;
use Illuminate\Support\Facades\Storage;
use App\Models\Vendor\PaymentMethod;
use App\Models\Vendor\VendorBankDetails;
use App\Models\Vendor\Order;
use App\Models\User\Customer;
use App\Models\Vendor\Products\Product;
use Illuminate\Support\Collection;
use App\Models\Vendor\Products\Variations;
use App\Models\User\OrderAddress;
use App\Models\Vendor\OrderHistory;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserOrderSent;

class VendorController extends Controller
{
    //
    public function dashboard()
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');

            $vendor = Vendor::where('id', $vendor->id)->first();

            $ordersId = Order::where('vendor_id', $vendor->id)->pluck('customer_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $customers = Customer::whereIn('id', $ordersId)->get();

            $orders = Order::where('vendor_id', $vendor->id)->get();



            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $pendingOrders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();



            $completedOrderIds = OrderHistory::where('status', 'Completed')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $completedOrders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $completedOrderIds)
                ->get();

            $deliveredOrderIds = OrderHistory::where('status', 'Delivered')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $deliveredOrders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $deliveredOrderIds)
                ->get();

            $returnedOrderIds = OrderHistory::where('status', 'Returned')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $returnedOrders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $returnedOrderIds)
                ->get();



            $recievedPaymentsIds = OrderHistory::where('status', 'Delivered')->pluck('order_id')->toArray();
            $pendingPaymentsIds = OrderHistory::whereNot('status', 'Delivered')->pluck('order_id')->toArray();

            $recievedPayments = Order::where('vendor_id', $vendor->id)
                ->WhereIn('id', $recievedPaymentsIds)
                ->get();
            $recievedPayments1 = Order::where('vendor_id', $vendor->id)
                ->where('payment_method', 'Card')
                ->get();


            $pendingPayments = Order::where('vendor_id', $vendor->id)
                ->where('payment_method', 'Cash on Delivery')
                ->WhereIn('id', $pendingPaymentsIds)
                ->get();


            //$products = new Collection();
            // $customers = new Collection();

            // foreach($orders as $order){
            //     //$product = Product::where('id', $order->product_id)->first();
            //     $customer = Customer::where('id', $order->customer_id)->first();

            //     //$products->add($product);
            //     $customers->add($customer);
            // }

            $totalOrders = count($orders);
            $pendingOrders = count($pendingOrders);
            $completedOrders = count($completedOrders);
            $deliveredOrders = count($deliveredOrders);
            $returnedOrders = count($returnedOrders);
            $totalEarned = 0;

            $recievedPayment = 0;
            foreach ($recievedPayments as $payment) {
                $recievedPayment +=  $payment->amount;
            }
            foreach ($recievedPayments1 as $payment) {
                $recievedPayment +=  $payment->amount;
            }
            $pendingPayment = 0;
            foreach ($pendingPayments as $payment) {
                $pendingPayment +=  $payment->amount;
            }

            $totalEarned = $pendingPayment + $recievedPayment;
            $totalCustomers = count($customers);

            return view('vendor.vendorAdminPanel.home', compact('vendor', 'totalOrders', 'pendingOrders', 'completedOrders', 'totalEarned', 'totalCustomers', 'recievedPayment', 'pendingPayment', 'deliveredOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function profile()
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->with('vendorFb')->first();
            $store = Store::where('vendor_id', $vendor->id)->first();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);
            return view('vendor.vendorAdminPanel.profile', compact('vendor', 'store', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function updateProfile(Request $request, $id)
    {
        if (Session::has('vendor')) {

            $vendor = Vendor::where('id', $id)->first();

            $validated = $request->validate([
                'name' => 'required|max:255',
                'phone' => 'required|numeric|min:3000000000|max:923999999999',
                'address' => 'required|max:255',
                'bio' => 'required|max:600',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $vendor->name = $validated['name'];
            $vendor->phone = $validated['phone'];
            $vendor->address = $validated['address'];
            $vendor->bio = $validated['bio'];

            if ($request->hasFile('avatar')) {
                // Delete previous profile picture if exists
                if ($vendor->avatar) {
                    Storage::delete('public/vendor/avatars/' . $vendor->avatar);
                }

                // Upload new profile picture
                $profilePic = $request->file('avatar');
                $fileName = time() . '_' . $profilePic->getClientOriginalName();
                $profilePic->storeAs('public/vendor/avatars', $fileName);

                // Update vendor's profile picture in the database
                $vendor->avatar = $fileName;
            }

            $vendor->save();

            return redirect()->route('vendorProfile', ['vendorName' => $vendor->name]);
        } else {
            return redirect()->route('home');
        }
    }


    // vendor store functions

    public function storePage()
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();
            $store = Store::where('vendor_id', $vendor->id)->first();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);

            return view('vendor.vendorAdminPanel.store', compact('vendor', 'store', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function createStorePage()
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);

            return view('vendor.vendorAdminPanel.createStore', compact('vendor', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function createStore(Request $request, $id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();

            $validated = $request->validate([
                'name' => 'required|max:255',
                'phone' => 'required|numeric|min:3000000000|max:923999999999',
                'slogan' => 'required|max:255',
                'description' => 'required|max:600',
                'address' => 'required|max:255',
                'openingDay' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'openingTime' => 'required|date_format:H:i',
                'closingDay' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'closingTime' => 'required|date_format:H:i|after:openingTime',
                'productHeading' => 'required|max:50',
                'productSubHeading' => 'required|max:50',
                'categoriesHeading' => 'required|max:50',
                'categoriesSubHeading' => 'required|max:50',
                'banner' => 'required|image:jpeg,png,jpg,gif|max:5120',
            ]);

            $store = new Store();
            $store->name = $validated['name'];
            $store->phone = $validated['phone'];
            $store->slogan = $validated['slogan'];
            $store->description = $validated['description'];
            $store->address = $validated['address'];
            $store['opening-day'] = $validated['openingDay'];
            $store['opening-time'] = $validated['openingTime'];
            $store['closing-day'] = $validated['closingDay'];
            $store['closing-time'] = $validated['closingTime'];
            $store['p-heading'] = $validated['productHeading'];
            $store['p-subheading'] = $validated['productSubHeading'];
            $store['c-heading'] = $validated['categoriesHeading'];
            $store['c-subheading'] = $validated['categoriesSubHeading'];
            $store->vendor_id = $id;

            // $store = new Store();
            // $store->name = $request->name;
            // $store->phone = $request->phone;
            // $store->slogan = $request->slogan;
            // $store->description = $request->description;
            // $store->address = $request->address;
            // $store['opening-day'] = $request->openingDay;
            // $store['opening-time'] = $request->openingTime;
            // $store['closing-day'] = $request->closingDay;
            // $store['closing-time'] = $request->closingTime;
            // $store['p-heading'] = $request->productHeading;
            // $store['p-subheading'] = $request->productSubHeading;
            // $store['c-heading'] = $request->categoriesHeading;
            // $store['c-subheading'] = $request->categoriesSubHeading;
            // $store->vendor_id = $id;


            if ($request->hasFile('banner')) {

                // Upload new profile picture
                $banner = $request->file('banner');
                $fileName = time() . '_' . $banner->getClientOriginalName();
                $banner->storeAs('public/vendor/store/banner', $fileName);

                // Update vendor's profile picture in the database
                $store->banner = $fileName;
            }

            $store->save();

            return redirect()->route('vendorStore', ['vendorName' => $vendor->name]);
        } else {
            return redirect()->route('home');
        }
    }

    public function editStorePage()
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();
            $store = Store::where('vendor_id', $vendor->id)->first();

            if (empty($store)) {
                return redirect()->route('vendorStore', ['vendorName', $vendor->name]);
            } else {
                $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

                // Retrieve orders for the vendor with pending status
                $orders = Order::where('vendor_id', $vendor->id)
                    ->whereIn('id', $pendingOrderIds)
                    ->get();
                $pendingOrders = count($orders);
                return view('vendor.vendorAdminPanel.editStore', compact('vendor', 'store', 'pendingOrders'));
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function updateStore(Request $request, $id)
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $store = Store::where('id', $id)->first();

            $validated = $request->validate([
                'name' => 'required|max:255',
                'phone' => 'required|numeric|min:3000000000|max:923999999999',
                'slogan' => 'required|max:255',
                'description' => 'required|max:600',
                'address' => 'required|max:255',
                'openingDay' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'openingTime' => 'required|date_format:H:i',
                'closingDay' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                'closingTime' => 'required|date_format:H:i|after:openingTime',
                'productHeading' => 'required|max:50',
                'productSubHeading' => 'required|max:50',
                'categoriesHeading' => 'required|max:50',
                'categoriesSubHeading' => 'required|max:50',
                'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            ]);


            $store->name = $validated['name'];
            $store->phone = $validated['phone'];
            $store->slogan = $validated['slogan'];
            $store->description = $validated['description'];
            $store->address = $validated['address'];
            $store['opening-day'] = $validated['openingDay'];
            $store['opening-time'] = $validated['openingTime'];
            $store['closing-day'] = $validated['closingDay'];
            $store['closing-time'] = $validated['closingTime'];
            $store['p-heading'] = $validated['productHeading'];
            $store['p-subheading'] = $validated['productSubHeading'];
            $store['c-heading'] = $validated['categoriesHeading'];
            $store['c-subheading'] = $validated['categoriesSubHeading'];



            if ($request->hasFile('banner')) {
                // Delete previous profile picture if exists
                if ($store->banner) {
                    Storage::delete('public/vendor/store/banner/' . $store->banner);
                }

                // Upload new profile picture
                $banner = $request->file('banner');
                $fileName = time() . '_' . $banner->getClientOriginalName();
                $banner->storeAs('public/vendor/store/banner', $fileName);

                // Update vendor's profile picture in the database
                $store->banner = $fileName;
            }

            $store->save();

            return redirect()->route('vendorStore', ['vendorName' => $vendor->name]);
        } else {
            return redirect()->route('home');
        }
    }

    public function storePreview($id)
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();
            $store = Store::where('id', $id)->first();



            return view('vendor.vendorAdminPanel.storePreview', compact('vendor', 'store'));
        } else {
            return redirect()->route('home');
        }
    }

    public function deleteStore($id)
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();
            $store = Store::where('id', $id)->first();

            if ($store) {
                $store->delete();
            }
            return redirect()->route('vendorStore', ['vendorName', $vendor->name]);
        } else {
            return redirect()->route('home');
        }
    }

    public function paymentPage()
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();
            $paymentMethods = PaymentMethod::where('vendor_id', $vendor->id)->get();

            $bankDetails = VendorBankDetails::where('vendor_id', $vendor->id)->first();

            return view('vendor.vendorAdminPanel.payment', compact('vendor', 'paymentMethods', 'bankDetails'));
        } else {
            return redirect()->route('home');
        }
    }

    public function addPaymentMethod(Request $request, $id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();

            $validated = $request->validate([
                'paymentMethod' => 'required|in:Easypaisa,Credit Card,Debit Card,Stripe,Cash on Delivery,Jazzcash',
            ]);

            $paymentMethod = new PaymentMethod();
            $paymentMethod->vendor_id = $id;
            $paymentMethod->payment_method = $validated['paymentMethod'];

            $paymentMethod->save();


            return redirect()->route('paymentPage', ['vendorName' => $vendor->name]);
        } else {
            return redirect()->route('home');
        }
    }

    public function removePaymentMethod($id)
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $paymentMethod = PaymentMethod::where('id', $id)->first();

            $paymentMethod->delete();


            return redirect()->route('paymentPage', ['vendorName' => $vendor->name]);
        } else {
            return redirect()->route('home');
        }
    }

    public function orderDetails($id)
    {
        if (Session::has('vendor')) {

            $vendor = Vendor::where('id', $id)->first();

            //$orders = Order::where('vendor_id', $vendor->id)->get();
            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);

            //$products = new Collection();
            $customers = new Collection();

            foreach ($orders as $order) {
                //$product = Product::where('id', $order->product_id)->first();
                $customer = Customer::where('id', $order->customer_id)->first();

                //$products->add($product);
                $customers->add($customer);
            }


            return view('vendor.vendorAdminPanel.orderDetails', compact('vendor', 'orders', 'customers', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function singleOrderDetails($id, $order_id)
    {
        if (Session::has('vendor')) {

            $vendor = Vendor::where('id', $id)->first();

            $order = Order::where('id', $order_id)->first();
            $orderAddress = OrderAddress::where('order_id', $order->id)->first();

            $product = Product::where('id', $order->product_id)->with('variations')->first();
            $customer = Customer::where('id', $order->customer_id)->first();
            $variation = Variations::where('id', $order->variation_id)->first();

            $orderHistory = OrderHistory::where('order_id', $order->id)->first();
            $store = Store::where('vendor_id', $vendor->id)->first();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);


            return view('vendor.vendorAdminPanel.singleOrder', compact('vendor', 'product', 'customer', 'variation', 'order', 'orderAddress', 'orderHistory', 'store', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function fullfillOrder($id, $order_id)
    {
        if (Session::has('vendor')) {

            $vendor = Vendor::where('id', $id)->first();

            $order = OrderHistory::where('order_id', $order_id)->first();

            $order->status = "Completed";

            $order->save();

            $order = Order::where('id', $order_id)->first();
            $customer = Customer::where('id', $order->customer_id)->first();
            $product = Product::where('id', $order->product_id)->first();
            $toEmail = $customer->email;
            Mail::to($toEmail)->send(new UserOrderSent($customer, $order, $product));


            return redirect()->route('orderDetails', ['id' => $vendor->id])->with('success', 'Order Completed Successfully');
        } else {
            return redirect()->route('home');
        }
    }


    public function deliverdOrder($id, $order_id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();

            $order = OrderHistory::where('order_id', $order_id)->first();
            $order->status = "Delivered";

            $order->save();
            // $customer = Customer::where('id', $order->customer_id)->first();
            // $product = Product::where('id', $order->product_id)->first();





            //dd(Session::get('orderDelivered'));
            // $toEmail = $customer->email;
            // Mail::to($toEmail)->send(new UserOrderSent($customer, $order, $product));

            return redirect()->route('orderHistory', ['id' => $vendor->id]);
        } else {
            return redirect()->route('home');
        }
    }

    public function orderHistory($id)
    {
        if (Session::has('vendor')) {

            $vendor = Vendor::where('id', $id)->first();

            $completedOrderIds = OrderHistory::whereNot('status', 'Pending')->pluck('order_id')->toArray();

            $orderHistory = OrderHistory::whereNot('status', 'Pending')->get();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $completedOrderIds)
                ->get();


            //$products = new Collection();
            $customers = new Collection();

            foreach ($orders as $order) {
                //$product = Product::where('id', $order->product_id)->first();
                $customer = Customer::where('id', $order->customer_id)->first();

                //$products->add($product);
                $customers->add($customer);
            }

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $p_order = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($p_order);

            $shippedOrderIds = OrderHistory::where('status', 'Completed')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $s_order = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $shippedOrderIds)
                ->get();
            $shippedOrders = count($s_order);

            $deliveredOrderIds = OrderHistory::where('status', 'Delivered')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $d_order = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $deliveredOrderIds)
                ->get();
            $deliveredOrders = count($d_order);

            $returnedOrderIds = OrderHistory::where('status', 'Returned')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $r_order = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $returnedOrderIds)
                ->get();
            $returnedOrders = count($r_order);

            return view('vendor.vendorAdminPanel.orderHistory', compact('vendor', 'orders', 'customers', 'orderHistory', 'pendingOrders', 'shippedOrders', 'deliveredOrders', 'returnedOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    // public function orderHistoryDetail($id){
    //     $vendor = Vendor::where('id', $id)->first();

    //     return view('vendor.vendorAdminPanel.orderHistoryDetail', compact('vendor'));
    // }


    // customers of vendor

    public function vendorCustomers($id)
    {
        if (Session::has('vendor')) {

            $vendor = Vendor::where('id', $id)->first();

            $ordersId = Order::where('vendor_id', $vendor->id)->pluck('customer_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $customers = Customer::whereIn('id', $ordersId)->get();


            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);


            return view('vendor.vendorAdminPanel.customers', compact('vendor', 'customers', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    //Payment History of vendor

    public function paymentHistory($id)
    {

        if (Session::has('vendor')) {

            $vendor = Vendor::where('id', $id)->first();

            $ordersId = Order::where('vendor_id', $vendor->id)->pluck('customer_id')->toArray();

            $orders = Order::where('vendor_id', $vendor->id);

            // Retrieve orders for the vendor with pending status
            $customers = Customer::whereIn('id', $ordersId)->get();


            $pendingOrderIds = OrderHistory::whereNot('status', 'Delivered')->pluck('order_id')->toArray();

            $recievedPaymentsIds = OrderHistory::where('status', 'Delivered')->pluck('order_id')->toArray();

            $recievedPayments = Order::where('vendor_id', $vendor->id)
                ->WhereIn('id', $recievedPaymentsIds)
                ->get();
            $recievedPayments1 = $orders
                ->where('payment_method', "Card")
                ->get();


            $pendingPayments = Order::where('vendor_id', $vendor->id)
                ->where('payment_method', 'Cash on Delivery')
                ->WhereIn('id', $pendingOrderIds)
                ->get();

            $totalEarned = 0;
            $recievedPayment = 0;
            foreach ($recievedPayments as $payment) {
                $recievedPayment +=  $payment->amount;
            }
            foreach ($recievedPayments1 as $payment) {
                $recievedPayment +=  $payment->amount;
            }
            $pendingPayment = 0;
            foreach ($pendingPayments as $payment) {
                $pendingPayment +=  $payment->amount;
            }

            $totalEarned = $pendingPayment + $recievedPayment;
            $orders = $orders->get();

            $orderHistories = new Collection();

            foreach ($orders as $order) {
                //$product = Product::where('id', $order->product_id)->first();
                $orderHistory = OrderHistory::where('order_id', $order->id)->first();

                //$products->add($product);
                $orderHistories->add($orderHistory);
            }

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders1 = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders1);


            return view('vendor.vendorAdminPanel.paymentHistory', compact('totalEarned', 'pendingPayment', 'recievedPayment', 'vendor', 'orders', 'customers', 'orderHistories', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }



    public function returnedOrder($id, $order_id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();

            $order = Order::where('id', $order_id)->first();
            $orderHistory = OrderHistory::where('order_id', $order_id)->first();
            $orderHistory->status = "Returned";

            $variation_id = $order->variation_id;
            $product_id = $order->product_id;

            $product = Product::where('id', $product_id)->with('variations')->first();
            //dd($product);
            foreach ($product->variations as $product_variation) {
                if ($product_variation->id == $variation_id) {
                    $product_variation->pivot->quantity += $order->quantity;
                    $product_variation->pivot->save();
                }
            }

            $orderHistory->save();
            $customer = Customer::where('id', $order->customer_id)->first();
            $product = Product::where('id', $order->product_id)->first();
            // $toEmail = $customer->email;
            // Mail::to($toEmail)->send(new UserOrderSent($customer, $order, $product));

            return redirect()->back();
        }
    }
}

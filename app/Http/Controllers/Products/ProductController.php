<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Products\Variations;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Products\Product_categories;
use App\Models\Vendor\Store;
use App\Models\Vendor\PaymentMethod;
use Illuminate\Support\Facades\Storage;
use App\Models\Vendor\FacebookAuthorization;
use App\Models\User\Cart;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Route;
use App\Models\Vendor\Order;
use App\Models\Vendor\OrderHistory;
use App\Models\User\Customer;
use App\Models\Vendor\Products\ProductReview;


class ProductController extends Controller
{
    //
    public function productView($product_id)
    {
        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $customer = Customer::where('id', $customer->id)->first();
            $customerId = $customer->id;
            $allcategories = Product_categories::all();
            $customers = Customer::all();
            $cartAmount = 0;
            $totalcart = Cart::where('customer_id', $customer->id)->get();
            foreach ($totalcart as $key => $number) {
                $cartAmount++;
            }


            $product = Product::where('id', $product_id)->with('paymentMethods', 'variations', 'reviews')->first();
            $store = Store::where('id', $product->store_id)->first();



            return view('product', compact('customer', 'product', 'customerId', 'allcategories', 'cartAmount', 'store', 'customers'));
        } else {
            $product = Product::where('id', $product_id)->with('paymentMethods', 'variations', 'reviews')->first();
            $customerId = 0;
            $allcategories = Product_categories::all();
            $store = Store::where('id', $product->store_id)->first();
            $customers = Customer::all();

            return view('product', compact('product', 'customerId', 'allcategories', 'store', 'customers'));
        }
    }

    public function addProductPage()
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();
            $store = Store::where('vendor_id', $vendor->id)->first();
            $categories = Product_categories::where('vendor_id', $vendor->id)->get();
            $variations = Variations::where('vendor_id', $vendor->id)->get();
            $paymentMethods = PaymentMethod::where('vendor_id', $vendor->id)->get();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);

            return view('vendor.vendorAdminPanel.products.addProduct', compact('vendor', 'variations', 'categories', 'store', 'paymentMethods', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function addProduct(Request $request, $id)
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();
            $storeId = $id;

            $validated = $request->validate([
                'name' => 'required',
                'category' => 'required|exists:product_categories,id',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'required|numeric|min:0',
                // 'paymentMethod' => 'required|array|min:1',
                'checked_variations' => 'required|array|min:1', // Ensure at least one variation is selected
            ]);

            //dd($validated['checked_variations']);

            if ($validated['checked_variations'][0] == null) {
                return redirect()->back()->with('error', 'Select Atleast One Variation');
            }

            //dd($request->paymentMethod);

            $checked_variations = [];

            foreach ($request->variations as $variation) {
                if (array_key_first($variation) === 'id') {
                    array_push($checked_variations, $variation);
                }
            }
            $request->variations = $checked_variations;
            //dd($request->variations);
            //  $variationRules = [
            //     'id' => 'required|exists:variations,id',
            //     'quantity' => 'required|numeric|min:0',
            //     'price_modifier' => 'required|numeric',
            //  ];

            //  foreach ($request->variations as $index => $variation) {
            //     // Validate each variation individually
            //     $validator = \Illuminate\Support\Facades\Validator::make($variation, $variationRules);

            //     // Check if validation fails for any variation
            //     if ($validator->fails()) {
            //         // Handle validation failure (e.g., return validation errors)
            //         return redirect()->back()->withErrors($validator)->withInput();
            //     }
            // }

            // Create new product
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->cat_id = $request->category;
            $product->store_id = $storeId;

            if ($request->hasFile('image')) {
                // Upload new profile picture
                $profilePic = $request->file('image');
                $fileName = time() . '_' . $profilePic->getClientOriginalName();
                $profilePic->storeAs('public/vendor/products/images', $fileName);

                // Update vendor's profile picture in the database
                $product->image = $fileName;
            }
            // You might need to adjust this if there are more fields in the form
            $product->save();

            // Attach variations to the product with quantity and price modifier

            foreach ($request->variations as $variation) {
                if ($variation['quantity'] === null) {
                    $variation['quantity'] = 0;
                }
                if ($variation['price_modifier'] === null) {
                    $variation['price_modifier'] = 0;
                }
                $fileName = '';

                if (isset($variation['img'])) {
                    $profilePic = $variation['img'];
                    $fileName = time() . '_' . $profilePic->getClientOriginalName();
                    $profilePic->storeAs('public/vendor/products/images', $fileName);
                }



                $product->variations()->attach($variation['id'], [
                    'quantity' => $variation['quantity'],
                    'price_modifier' => $variation['price_modifier'],
                    'image' => $fileName,
                ]);
            }

            // foreach ($request->paymentMethod as $method) {
            //     $product->paymentMethods()->attach($method);
            // }

            // Check if vendor has authorized Facebook posting
            //$vendor = auth()->guard('vendor')->user(); // Replace with your vendor authentication method
            $authorization = FacebookAuthorization::where('vendor_id', $vendor->id)->first();

            if ($authorization && $authorization->facebook_access_token) {
                try {
                    $this->postProductToFacebook($product, $authorization->facebook_access_token);
                    return redirect()->route('addProductPage', ['vendorName' => $vendor->name])->with('success', 'Product added and posted to Facebook successfully!');
                } catch (\Exception $e) {
                    return back()->withErrors(['facebook_error' => 'Failed to post to Facebook: ' . $e->getMessage()])->withInput();
                }
            } else {
                return redirect()->route('addProductPage', ['vendorName' => $vendor->name])->with('success', 'Product added successfully. Please connect your Facebook page to post products.');
            }



            // return redirect()
            //     ->route('addProductPage', ['vendorName' => $vendor->name])
            //     ->with('success', 'Product created successfully!');
        } else {
            return redirect()->route('home');
        }
    }

    private function postProductToFacebook(Product $product, string $accessToken)
    {
        // Use Laravel Socialite or Guzzle HTTP (depending on your approach)
        // to interact with Facebook Graph API and post product information
        // Replace with your implementation

        // Example using Guzzle (replace with actual API call)
        $client = new Client();
        $response = $client->post('https://graph.facebook.com/v13.0/' . $authorization->facebook_page_id . '/posts', [
            'form_params' => [
                'message' => $product->name . "\n" . $product->description,
                'access_token' => $accessToken,
            ],
        ]);

        // Check for successful response
        if ($response->getStatusCode() === 200) {
            // Handle successful post
        } else {
            throw new \Exception('Failed to post to Facebook: ' . $response->getBody());
        }
    }



    public function productList($id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();

            $store = Store::where('vendor_id', $id)->first();
            if ($store) {
                $products = Product::where('store_id', $store->id)
                    ->with('paymentMethods')
                    ->get();
            } else {
                $products = [];
            }

            $categories = Product_categories::all();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);

            return view('vendor.vendorAdminPanel.products.productList', compact('vendor', 'products', 'store', 'categories', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function editProductPage($vendorName, $id, UrlGenerator $url)
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();
            $store = Store::where('vendor_id', $vendor->id)->first();
            $categories = Product_categories::where('vendor_id', $vendor->id)->get();
            $variations = Variations::where('vendor_id', $vendor->id)->get();
            $paymentMethods = PaymentMethod::where('vendor_id', $vendor->id)->get();
            $product = Product::with('paymentMethods', 'variations')->where('id', $id)->first();

            $previousUrl = $url->previous();

            // Match the previous URL to a route
            $previousRoute = Route::getRoutes()->match(Request::create($previousUrl));

            // Get the name of the previous route
            $previousRouteName = $previousRoute->getName();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);

            return view('vendor.vendorAdminPanel.products.editProduct', compact('vendor', 'variations', 'categories', 'store', 'paymentMethods', 'product', 'previousRouteName', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function editProduct(Request $request, $id, $product_id)
    {
        if (Session::has('vendor')) {
            $vendor = Session::get('vendor');
            $vendor = Vendor::where('id', $vendor->id)->first();
            $storeId = $id;

            $validated = $request->validate([
                'name' => 'required',
                'category' => 'required|exists:product_categories,id',
                'description' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'required|numeric|min:0',
                //'paymentMethod' => 'required|array|min:1',
                'checked_variations' => 'required|array|min:1', // Ensure at least one variation is selected
            ]);

            //dd($request->paymentMethod);

            $checked_variations = [];

            foreach ($request->variations as $variation) {
                if (array_key_first($variation) === 'id') {
                    array_push($checked_variations, $variation);
                }
            }
            $request->variations = $checked_variations;

            $variationIds = [];

            foreach ($checked_variations as $variation) {
                if (isset($variation['id'])) {
                    $variationIds[] = $variation['id'];
                }
            }
            //$checked_variations =  $request->variations;
            //dd($request->variations);

            // Create new product
            $product = Product::with('paymentMethods', 'variations')->where('id', $product_id)->first();

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->cat_id = $request->category;
            $product->store_id = $storeId;

            if ($request->hasFile('image')) {
                //deleting previous image
                if ($product->image != null) {
                    Storage::delete('public/vendor/products/images/' . $product->image);
                }
                // Upload new profile picture
                $profilePic = $request->file('image');
                $fileName = time() . '_' . $profilePic->getClientOriginalName();
                $profilePic->storeAs('public/vendor/products/images', $fileName);

                // Update vendor's profile picture in the database
                $product->image = $fileName;
            }
            // You might need to adjust this if there are more fields in the form
            $product->save();

            $currentVariations = $product->variations()->pluck('variation_id')->toArray();
            // Get new variations from the request
            $newVariations = $variationIds;




            foreach ($request->variations as $variationData) {
                $variation = Variations::where('id', $variationData['id'])->first();

                $fileName = '';
                if (isset($variationData['img'])) {
                    $profilePic = $variationData['img'];
                    $fileName = time() . '_' . $profilePic->getClientOriginalName();
                    $profilePic->storeAs('public/vendor/products/images', $fileName);
                }
                //dd($variationData);

                // $product->variations()->syncWithoutDetaching([
                //     $variation->id => [
                //         'quantity' => $variationData['quantity'] ?? 0,
                //         'price_modifier' => $variationData['price_modifier'] ?? 0,
                //         'image' => $fileName ?? $product->variations()->image,
                //     ],
                // ]);


                foreach ($product->variations as $key => $productVariation) {

                    if ($variation->id == $productVariation->pivot->variation_id) {

                        if ($fileName == '') {
                            $fileName = $productVariation->pivot->image;
                        }


                        $productVariation->pivot->quantity = $variationData['quantity'] ?? 0;
                        $productVariation->pivot->price_modifier = $variationData['price_modifier'] ?? 0;
                        $productVariation->pivot->image = $fileName;
                        $productVariation->pivot->save();
                    }
                }
            }

            // Determine variations to add
            $variationsToAdd = array_diff($newVariations, $currentVariations);
            foreach ($variationsToAdd as $variationId) {
                $product->variations()->attach($variationId);
            }

            // Optionally, remove old variations that are no longer selected
            $variationsToRemove = array_diff($currentVariations, $newVariations);
            foreach ($variationsToRemove as $variationId) {
                $product->variations()->detach($variationId);
            }




            // Update existing payment methods
            // $product->paymentMethods()->sync($request->paymentMethod);

            // // Update payment methods
            // $product->paymentMethods()->sync($request->paymentMethod);

            // return redirect()->route('vendor.productList', ['id' => $vendor->id]);
            return redirect()->back();
        } else {
            return redirect()->route('home');
        }
    }

    public function deleteProduct($id, $product_id)
    {
        if (Session::has('vendor')) {
            $store = Store::where('id', $id)->first();
            $product = Product::where('id', $product_id)->with('paymentMethods', 'variations')->first();


            $product->variations()->detach();

            $product->paymentMethods()->detach();

            $product->delete();

            return redirect()->route('vendor.productList', ['id' => $store->vendor_id]);
        } else {
            return redirect()->route('home');
        }
    }

    public function productCategories($id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();
            $categories = Product_categories::where('vendor_id', $id)->get();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);

            return view('vendor.vendorAdminPanel.products.productCategories', compact('vendor', 'categories', 'pendingOrders'));
        } else {
            return Redirect()->route('home');
        }
    }

    public function createCategories(Request $request, $id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();

            $validated = $request->validate([
                'name' => 'required|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $category = new Product_categories();
            $category->name = $validated['name'];
            $category->vendor_id = $vendor->id;

            if ($request->hasFile('image')) {
                // Upload new profile picture
                $profilePic = $request->file('image');
                $fileName = time() . '_' . $profilePic->getClientOriginalName();
                $profilePic->storeAs('public/vendor/products/category/images', $fileName);

                // Update vendor's profile picture in the database
                $category->image = $fileName;
            }

            $category->save();

            return redirect()->route('productCategories', ['id' => $vendor->id]);
        } else {
            return redirect()->route('home');
        }
    }

    public function editCategories(Request $request, $id, $cat_id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();
            $category = Product_categories::where('id', $cat_id)->first();

            $validated = $request->validate([
                'name' => 'required|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $category->name = $request->name;
            $category->vendor_id = $vendor->id;

            if ($request->hasFile('image')) {
                if ($category->image) {
                    Storage::delete('public/vendor/products/category/images/' . $category->image);
                }
                // Upload new profile picture
                $profilePic = $request->file('image');
                $fileName = time() . '_' . $profilePic->getClientOriginalName();
                $profilePic->storeAs('public/vendor/products/category/images', $fileName);

                // Update vendor's profile picture in the database
                $category->image = $fileName;
            }

            $category->save();

            return redirect()->route('productCategories', ['id' => $vendor->id]);
        } else {
            return Redirect()->route('home');
        }
    }

    public function deleteCategories($id, $cat_id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();
            $category = Product_categories::where('id', $cat_id)->first();

            $category->delete();

            return redirect()->route('productCategories', ['id' => $vendor->id]);
        } else {
            return redirect()->route('home');
        }
    }

    public function productVariations($id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();
            $variations = Variations::where('vendor_id', $vendor->id)->get();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);
            return view('vendor.vendorAdminPanel.products.productVariations', compact('vendor', 'variations', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }

    public function createVariation(Request $request, $id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();

            $validated = $request->validate([
                'name' => 'required|max:255',
                'size' => 'max:255',
                'color' => 'string|max:7',
                'weight' => 'max:255',
                'material' => 'max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $variation = new Variations();
            $variation->name = $validated['name'];
            $variation->size = $validated['size'];
            $variation->color = $validated['color'];
            $variation->weight = $validated['weight'];
            $variation->material = $validated['material'];
            $variation->vendor_id = $vendor->id;

            if ($request->hasFile('image')) {
                // Upload new profile picture
                $profilePic = $request->file('image');
                $fileName = time() . '_' . $profilePic->getClientOriginalName();
                $profilePic->storeAs('public/vendor/products/variation/images', $fileName);

                // Update vendor's profile picture in the database
                $variation->image = $fileName;
            }

            $variation->save();

            return redirect()->route('productVariations', ['id' => $vendor->id]);
        } else {
            return redirect()->route('home');
        }
    }

    public function editVariation(Request $request, $id, $var_id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();
            $variation = Variations::where('id', $var_id)->first();

            $validated = $request->validate([
                'name' => 'required|max:255',
                'size' => 'max:255',
                'color' => 'string|max:7',
                'weight' => 'max:255',
                'material' => 'max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $variation->name = $validated['name'];
            $variation->size = $validated['size'];
            $variation->color = $validated['color'];
            $variation->weight = $validated['weight'];
            $variation->material = $validated['material'];
            $variation->vendor_id = $vendor->id;

            if ($request->hasFile('image')) {
                if ($variation->image != null) {
                    Storage::delete('public/vendor/products/variation/images/' . $product->image);
                }
                // Upload new profile picture
                $profilePic = $request->file('image');
                $fileName = time() . '_' . $profilePic->getClientOriginalName();
                $profilePic->storeAs('public/vendor/products/variation/images', $fileName);

                // Update vendor's profile picture in the database
                $variation->image = $fileName;
            }

            $variation->save();

            return redirect()->route('productVariations', ['id' => $vendor->id]);
        } else {
            return redirect()->route('home');
        }
    }

    public function deleteVariation($id, $var_id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();
            $variation = Variations::where('id', $var_id)->first();

            $variation->delete();

            return redirect()->route('productVariations', ['id' => $vendor->id]);
        } else {
            return redirect()->route('home');
        }
    }




    //Inventory management

    public function productInventory($id)
    {
        if (Session::has('vendor')) {
            $vendor = Vendor::where('id', $id)->first();

            $variations = Variations::all();

            $store = Store::where('vendor_id', $id)->first();
            if ($store) {
                $products = Product::where('store_id', $store->id)
                    ->with('paymentMethods', 'variations')
                    ->get();
            } else {
                $products = [];
            }

            $categories = Product_categories::all();

            // $previousUrl = $url->previous();

            // // Match the previous URL to a route
            // $previousRoute = Route::getRoutes()->match(Request::create($previousUrl));

            // // Get the name of the previous route
            // $previousRouteName = $previousRoute->getName();

            $pendingOrderIds = OrderHistory::where('status', 'Pending')->pluck('order_id')->toArray();

            // Retrieve orders for the vendor with pending status
            $orders = Order::where('vendor_id', $vendor->id)
                ->whereIn('id', $pendingOrderIds)
                ->get();
            $pendingOrders = count($orders);

            return view('vendor.vendorAdminPanel.inventory', compact('vendor', 'products', 'store', 'categories', 'variations', 'pendingOrders'));
        } else {
            return redirect()->route('home');
        }
    }


    public function reviewProductPage($id, $order_id)
    {
        if (Session::has('customer')) {
            $customer = Customer::where('id', $id)->first();

            $order = Order::where('id', $order_id)->first();

            $orderIds = ProductReview::where('customer_id', $customer->id)->pluck('order_id')->toArray();
            $orderIds1 = OrderHistory::where('status', 'Delivered')->whereNotIn('order_id', $orderIds)->pluck('order_id')->toArray();
            //$reviewableOrdersIds = Order::where('customer_id', $customer->id)->whereNotIn('id', $orderIds1)->pluck('order_id')->toArray();

            $reviewableOrders = Order::where('customer_id', $customer->id)->whereIn('id', $orderIds1)->get();
            //dd($reviewableOrders);
            foreach ($reviewableOrders as $orders) {
                //dd($order->id);
                if ($orders->id == $order->id) {
                    $product = Product::where('id', $order->product_id)->with('variations', 'reviews')->first();
                    $variations = Variations::all();
                    $cartAmount = 0;
                    $totalcart = Cart::where('customer_id', $customer->id)->get();
                    foreach ($totalcart as $key => $number) {
                        $cartAmount++;
                    }

                    return view('user.reviewProduct', compact('product', 'customer', 'cartAmount', 'variations', 'order'));
                }
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function reviewProduct(Request $request, $id, $order_id)
    {
        if (Session::has('customer')) {
            $customer = Customer::where('id', $id)->first();
            $order = Order::where('id', $order_id)->first();
            $product = Product::where('id', $order->product_id)->first();

            $validated = $request->validate([
                'rating' => 'required|max:5',
                'review' => 'required|max:500',
                'order_id' => 'required',
            ]);

            $review = new ProductReview();
            $review->product_id = $product->id;
            $review->customer_id = $customer->id;
            $review->order_id = $validated['order_id'];
            $review->rating = $validated['rating'];
            $review->review = $validated['review'];

            $review->save();

            return redirect()->route('customerProfile', ['customerName', $customer->id])->with('reviewSuccess', 'review given');
        } else {
            return redirect()->route('home');
        }
    }
}

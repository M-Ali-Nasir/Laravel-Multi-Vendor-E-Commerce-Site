<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Products\CategoryController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\BankDetailsController;
use App\Http\Controllers\Vendor\VendorFacebookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\Cart;
use App\Http\Controllers\AdminController;




// Home Page
Route::get('/', [HomeController::class, 'home'])->name('home');

// Load More Products
Route::get('/more-products', [HomeController::class, 'loadMoreProducts'])->name('loadMoreProducts');

Route::get('/forget_password', [AuthController::class, 'userForgetPassword'])->name('userForgetPassword');
Route::get('/vendor/forget_password', [VendorAuthController::class, 'vendorForgetPassword'])->name('vendorForgetPassword');

Route::post('/forget-password/send-mail', [AuthController::class, 'forgetPasswordSendMail'])->name('forgetPasswordSendMail');
Route::post('/vendor/forget-password/send-mail', [VendorAuthController::class, 'vendorForgetPasswordSendMail'])->name('vendorForgetPasswordSendMail');
Route::get('/reset-password-view/{id}/user/{usertype}', [AuthController::class, 'resetPasswordView'])->name('resetPasswordView');
Route::post('/resest-password/{id}', [AuthController::class, 'resetPassword'])->name('resetPassword');

//Privacy Policy

Route::get('/privacy-policy', [HomeController::class, 'privayPolicy'])->name('privacyPolicy');

//About page route
Route::get('/about', [HomeController::class, 'aboutPage'])->name('aboutPage');

// All shops page

Route::get('/all-shops', [HomeController::class, 'allShopsPage'])->name('allShopsPage');

// single shope page
Route::get('/shop/{id}', [HomeController::class, 'shopPage'])->name('ShopPage');
Route::get('/shop/{id}/contact/{vendor_id}', [HomeController::class, 'contactVendor'])->name('contactVendor');

//categoriespage
Route::get('/home/category/{id}', [HomeController::class, 'categoryPage'])->name('categoryPage');
// Customer Home page

Route::get('/home/{customerName}', [AuthController::class, 'customerIndex'])->name('customerIndex');

// User authentication routes

Route::get('/login', [AuthController::class, 'loginPage'])->name('customerLogin');
Route::get('/register', [AuthController::class, 'registerPage'])->name('customerRegister');
Route::post('/register-user', [AuthController::class, 'registerUser'])->name('registerCustomer');
Route::post('/customer', [AuthController::class, 'loginUser'])->name('loginCustomer');
Route::get('/customer/logout', [AuthController::class, 'logoutUser'])->name('logoutCustomer');


//User customer page Routes

Route::get('/home/profile/{customerName}', [UserController::class, 'customerProfile'])->name('customerProfile');
Route::post('/home/profile/update/{id}', [UserController::class, 'updateCustomerProfile'])->name('updateCustomerProfile');
Route::get('/home/cart/{customerName}', [UserController::class, 'customerCart'])->name('customerCart');


//User Cart routes
Route::get('/home/cart/{customerId}/add-product/{productId}', [Cart::class, 'addToCart'])->name('addToCart');
Route::get('/home/cart/{id}/delete-item/{item_id}', [Cart::class, 'deleteCartItem'])->name('deleteCartItem');
Route::get('/home/cart/{id}/delete-cart/', [Cart::class, 'deleteCart'])->name('deleteCart');


// Product categories page

Route::get('/home/products/category-name/', [CategoryController::class, 'categoryView'])->name('productsCategory');


// Single product 

Route::get('/home/product/{product_id}/', [ProductController::class, 'productView'])->name('productView');

// Checkout

Route::get('/home/{id}/checkout', [CheckoutController::class, 'CheckoutView'])->name('checkoutView');
Route::post('/home/{id}/checkout/shipping-billing-address', [UserController::class, 'addShippingBillingAddress'])->name('addShippingBillingAddress');
Route::get('/home/{id}/stripe/checkout/{orderAddress}', [CheckoutController::class, 'stripeCheckout'])->name('stripe.checkout');
Route::get('/home/stripe/checkout/success/{customerId}', [CheckoutController::class, 'stripeCheckoutSuccess'])->name('stripe.checkout.success');
Route::get('/home/{id}/checkout/order-completed', [UserController::class, 'orderCompleted'])->name('orderCompleted');

// Order Reviews

Route::get('/home/{id}/review-product/{order_id}', [ProductController::class, 'reviewProductPage'])->name('reviewProductPage');
Route::post('/home/{id}/review/{order_id}', [ProductController::class, 'reviewProduct'])->name('reviewProduct');

//Track Orders

Route::get('/home/{id}/track-orders', [UserController::class, 'trackOrders'])->name('trackOrders');



// vendor authentication

Route::get('/vendor/login', [VendorAuthController::class, 'loginPage'])->name('vendorLogin');
Route::get('/vendor/register', [VendorAuthController::class, 'registerPage'])->name('vendorRegistration');
Route::post('/register-vendor', [VendorAuthController::class, 'registerVendor'])->name('registerVendor');
Route::post('/login-vendor', [VendorAuthController::class, 'loginVendor'])->name('loginVendor');
Route::post('/Vendor/logout', [VendorAuthController::class, 'logoutVendor'])->name('logoutVendor');

//vendor admin panel

Route::get('/vendor/admin/{vendorName}', [VendorController::class, 'dashboard'])->name('vendorDashboard');
Route::get('/vendor/admin/{vendorName}/profile', [VendorController::class, 'profile'])->name('vendorProfile');

// update vendor profile

Route::post('/vendor/admin/{id}', [VendorController::class, 'updateProfile'])->name('updateProfile');

// vendor store page
Route::get('vendor/admin/{vendorName}/store', [VendorController::class, 'storePage'])->name('vendorStore');
//create store
Route::get('vendor/admin/{vendorName}/create-store', [VendorController::class, 'createStorePage'])->name('createStorePage');
Route::post('vendot/admin/{id}/create/new-store', [VendorController::class, 'createStore'])->name('createStore');
// edit store
Route::get('vendor/admin/{vendorName}/Edit-store', [VendorController::class, 'editStorePage'])->name('editStorePage');
Route::post('vendor/admin/{id}/edit/store', [VendorController::class, 'updateStore'])->name('updateStore');
Route::get('vendor/admin/{id}/delete/store', [VendorController::class, 'deleteStore'])->name('deleteStore');
// store preview
Route::get('vendor/admin/{id}/store-preview', [VendorController::class, 'storePreview'])->name('storePreview');


// Payment Setting

Route::get('vendor/admin/{vendorName}/ayment-setting', [VendorController::class, 'paymentPage'])->name('paymentPage');
Route::post('vendor/admin/{id}/add-payment/method', [VendorController::class, 'addPaymentMethod'])->name('addPaymentMethod');
Route::get('vendor/admin/{id}/delete-payment/', [VendorController::class, 'removePaymentMethod'])->name('removePaymentMethod');
// Bank details
Route::post('vendor/admin/{id}/update-bank-details', [BankDetailsController::class, 'saveBankDetails'])->name('saveBankDetails');

// Product Routes

Route::get('vendor/admin/{vendorName}/add-new-product', [ProductController::class, 'addProductPage'])->name('addProductPage');
Route::post('vendor/admin/{id}/add-new-product', [ProductController::class, 'addProduct'])->name('addProduct');
Route::get('vendor/admin/{id}/product-list', [ProductController::class, 'productList'])->name('vendor.productList');
Route::get('vendor/admin/{vendorName}/{id}/edit-product', [ProductController::class, 'editProductPage'])->name('editProductPage');
Route::post('vendor/admin/{id}/{product_id}/edit-product', [ProductController::class, 'editProduct'])->name('editProduct');
Route::get('vendor/admin/{id}/{product_id}/delete_product', [ProductController::class, 'deleteProduct'])->name('deleteProduct');


// Route for initiating Facebook authorization
Route::get('/vendor/facebook/connect', [VendorFacebookController::class, 'connectToFacebook'])->name('vendor.facebook.connect');

// Route for handling Facebook authorization callback
Route::get('facebook/callback', [VendorFacebookController::class, 'handleFacebookCallback']);

//Product categories

Route::get('vendor/admin/{id}/product-categories', [ProductController::class, 'productCategories'])->name('productCategories');
Route::post('vendor/admin/{id}/create-new-category', [ProductController::class, 'createCategories'])->name('createCategories');
Route::post('vendor/admin/{id}/{cat_id}/edit-category', [ProductController::class, 'editCategories'])->name('editCategories');
Route::get('vendor/admin/{id}/{cat_id}/delete-category', [ProductController::class, 'deleteCategories'])->name('deleteCategories');


//product variations 

Route::get('vendor/admin/{id}/product-variations', [ProductController::class, 'productVariations'])->name('productVariations');
Route::post('vendor/admin/{id}/create-new-variation', [ProductController::class, 'createVariation'])->name('createVariation');
Route::post('vendor/admin/{id}/{var_id}/edit-variation', [ProductController::class, 'editVariation'])->name('editVariation');
Route::get('vendor/admin/{id}/{var_id}/delete-variation', [ProductController::class, 'deleteVariation'])->name('deleteVariation');

Route::get('vendor/admin/{id}/product-Inventory', [ProductController::class, 'productInventory'])->name('productInventory');
//Orders routes

Route::get('vendor/admin/{id}/order-details', [VendorController::class, 'orderDetails'])->name('orderDetails');
Route::get('vendor/admin/{id}/oder-details/{order_id}', [VendorController::class, 'singleOrderDetails'])->name('singleOrderDetails');

Route::get('vendor/admin/{id}/fullfill-order/{order_id}', [VendorController::class, 'fullfillOrder'])->name('fullfillOrder');
Route::get('vendor/admin/{id}/delivered-order/{order_id}', [VendorController::class, 'deliverdOrder'])->name('deliverdOrder');
Route::get('vendor/admin/{id}/returned-order/{order_id}', [VendorController::class, 'returnedOrder'])->name('returnedOrder');


//order History

Route::get('vendor/admin/{id}/order-histroy', [VendorController::class, 'orderHistory'])->name('orderHistory');
// Route::get('vendor/admin/{id}/order-history/order-id',[VendorController::class, 'orderHistoryDetail'])->name('orderHistoryDetail');

//vendor's all customers
Route::get('vendor/admin/{id}/customers', [VendorController::class, 'vendorCustomers'])->name('vendorCustomers');

//vendor's payments

Route::get('vendor/admin/{id}/payments-history', [VendorController::class, 'paymentHistory'])->name('paymentHistory');


//activate vendor routes

Route::get('vendor/admin/{id}/activation-varification', [VendorAuthController::class, 'activation'])->name('activation');
Route::post('venor/admin/activate/{id}', [VendorAuthController::class, 'activateVendor'])->name('activate');

//Route to contact us

Route::post('/home/contact-us-by-mail', [HomeController::class, 'contactUsMail'])->name('contactUsMail');



//      ADMIN ROUETS

Route::get('/admin/login', [AdminController::class, 'loginPage'])->name('admin.loginPage');
Route::get('/admin/register', [AdminController::class, 'registerPage'])->name('admin.registerPage');
Route::get('/admin/dashboard/{id}/logged-in', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/dashboard/{id}/customers', [AdminController::class, 'customersPage'])->name('admin.customers');
Route::get('/admin/dashboard/{id}/vendors', [AdminController::class, 'vendorsPage'])->name('admin.vendors');

//login Admin 

Route::post('/admin/login-admin', [AdminController::class, 'loginAdmin'])->name('admin.login');
Route::post('/admin/logout-admin', [AdminController::class, 'logoutAdmin'])->name('admin.logout');

Route::get('/admin/customer/{customer_id}/change-status-active', [AdminController::class, 'statusCustomerActive'])->name('admin.activeCustomer');
Route::get('/admin/customer/{customer_id}/change-status-inactive', [AdminController::class, 'statusCustomerInactive'])->name('admin.inactiveCustomer');
Route::get('/admin/customer/{customer_id}/change-status-ban', [AdminController::class, 'statusCustomerBan'])->name('admin.banCustomer');
Route::get('/admin/vendor/{vendor_id}/change-status-inactive', [AdminController::class, 'statusVendorInactive'])->name('admin.inactiveVendor');
Route::get('/admin/vendor/{vendor_id}/change-status-ban', [AdminController::class, 'statusVendorBan'])->name('admin.banVendor');
Route::get('/admin/vendor/{vendor_id}/change-status-active', [AdminController::class, 'statusVendorActive'])->name('admin.activeVendor');

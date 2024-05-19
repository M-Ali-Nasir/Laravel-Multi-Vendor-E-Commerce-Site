<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class CategoryController extends Controller
{
    //
    public function categoryView(){
        if(Session::has('customer')){
            $customer = Session::get('customer');
            $cartAmount =0;
            $totalcart = Cart::where('customer_id', $customer->id)->get();
            foreach ($totalcart as $key => $number) {
                $cartAmount++;
            }
            return view('categories',compact('customer','cartAmount'));
        }else{
            return view('categories');
        }
        
    }
}

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
            return view('categories',compact('customer'));
        }else{
            return view('categories');
        }
        
    }
}

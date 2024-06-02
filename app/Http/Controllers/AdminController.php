<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Session;
use App\Models\User\Customer;
use App\Models\Vendor\Vendor;

class AdminController extends Controller
{
    //login page view
    public function loginPage()
    {
        if (Session::has('admin')) {
            $admin = Session::get('admin');
            $admin = Admin::where('id', $admin->id)->first();
            $vendors = Vendor::all();
            $customers = Customer::all();
            return view('admin.adminPannel.dashboard', compact('vendors', 'customers', 'admin'));
        }
        return view('admin.login');
    }

    //Login in Admin

    public function loginAdmin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $validated['email'])->first();
        //dd($admin);
        if (isset($admin)) {
            if ($admin->password == $validated['password']) {
                Session::put('admin', $admin);
                return redirect()->route('admin.dashboard', ['id', $admin->id]);
            } else {
                return redirect()->back()->with('error', 'Incorrect password');
            }
        } else {
            return redirect()->back()->with('error', 'Incorrect email address');
        }
    }

    //logout admin

    public function logoutAdmin()
    {
        if (Session::has('admin')) {
            Session::forget('admin');
            return redirect()->route('admin.loginPage');
        }
    }

    //change customer status

    public function statusCustomerActive($id)
    {

        if (Session::has('admin')) {
            $customer = Customer::where('id', $id)->first();
            $customer->status = "active";
            $customer->save();
            return back()->with('success', "Status changed successfully");
        }
    }

    public function statusCustomerInactive($id)
    {
        if (Session::has('admin')) {
            $customer = Customer::where('id', $id)->first();
            $customer->status = "inactive";
            $customer->save();
            return back()->with('success', "Status changed successfully");
        }
    }
    public function statusCustomerBan($id)
    {
        if (Session::has('admin')) {
            $customer = Customer::where('id', $id)->first();
            $customer->status = "banned";
            $customer->save();
            return back()->with('success', "Status changed successfully");
        }
    }

    // vendor status change

    public function statusVendorActive($id)
    {
        if (Session::has('admin')) {
            $vendor = Vendor::where('id', $id)->first();
            $vendor->status = "active";
            $vendor->save();
            return back()->with('success', "Status changed successfully");
        }
    }

    public function statusVendorInactive($id)
    {
        if (Session::has('admin')) {
            $vendor = Vendor::where('id', $id)->first();
            $vendor->status = "inactive";
            $vendor->save();
            return back()->with('success', "Status changed successfully");
        }
    }

    public function statusVendorBan($id)
    {
        if (Session::has('admin')) {
            $vendor = Vendor::where('id', $id)->first();
            $vendor->status = "banned";
            $vendor->save();
            return back()->with('success', "Status changed successfully");
        }
    }


    //register page view

    public function registerPage()
    {
        return view('admin.register');
    }

    public function dashboard()
    {
        if (Session::has('admin')) {
            $admin = Session::get('admin');
            $admin = Admin::where('id', $admin->id)->first();
            $vendors = Vendor::all();
            $customers = Customer::all();
            return view('admin.adminPannel.dashboard', compact('vendors', 'customers', 'admin'));
        }
    }

    //vendors page
    public function vendorsPage()
    {
        if (Session::has('admin')) {

            $admin = Admin::where('id', Session::get('admin')->id)->first();
            $vendors = Vendor::all();

            return view('admin.adminPannel.allVendors', compact('vendors', 'admin'));
        }
    }



    //customers page
    public function customersPage()
    {
        if (Session::has('admin')) {

            $admin = Admin::where('id', Session::get('admin')->id)->first();
            $customers = Customer::all();
            return view('admin.adminPannel.allCustomers', compact('customers', 'admin'));
        }
    }
}

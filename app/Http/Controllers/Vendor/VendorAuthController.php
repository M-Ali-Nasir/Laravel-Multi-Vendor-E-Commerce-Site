<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorWelcomeEmail;
use Illuminate\Support\Str;
use App\Mail\VendorActivation;
use App\Mail\ForgetPassword;
use App\Models\Vendor\OrderHistory;
use App\Models\Vendor\Order;

class VendorAuthController extends Controller
{
    //
    public function loginPage()
    {
        return view('vendor.authentication.login');
    }

    public function registerPage()
    {
        return view('vendor.authentication.register');
    }

    public function registerVendor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email',
            'password' => 'required|string|min:6',
        ]);

        $user = new Vendor();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);

        $user->save();

        //sending welcome email to vendor
        $toEmail = $user->email;

        Mail::to($toEmail)->send(new VendorWelcomeEmail($user));

        return redirect()->route('vendorLogin');
    }

    public function loginVendor(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $vendor = Vendor::where('email', $validated['email'])->first();

        if ($vendor && Hash::check($validated['password'], $vendor->password)) {
            // Password is correct
            // Proceed with login...

            Session::put('vendor', $vendor);
            return redirect()->route('vendorDashboard', ['vendorName', $vendor->name]);
        } elseif ($vendor) {
            // Password is incorrect
            // Handle invalid login...
            return redirect()->back()->withErrors(['error' => 'Invalid Password']);
        }
        return redirect()->back()->withErrors(['error' => 'Invalid Email']);
    }

    public function logoutVendor()
    {
        if (Session::has('vendor')) {
            Session::forget('vendor');
            Session::forget('pendingOrders');
            return redirect()->route('home');
        }
        return redirect()->route('home');
    }

    public function activation($id)
    {
        $vendor = Vendor::where('id', $id)->first();

        $pin = mt_rand(100000, 999999);


        Mail::to($vendor->email)->send(new VendorActivation($vendor, $pin));

        if (Session::has("varification_pin")) {
            Session::forget("varification_pin");
        }
        Session::put("varification_pin", $pin);

        return view('vendor.authentication.activation', compact('vendor'));
    }

    public function activateVendor(Request $request, $id)
    {
        $vendor = Vendor::where('id', $id)->first();

        // $request->validate([
        //     'd1' => 'required|max:9',
        //     'd2' => 'required|max:9',
        //     'd3' => 'required|max:9',
        //     'd4' => 'required|max:9',
        //     'd5' => 'required|max:9',
        //     'd6' => 'required|max:9',
        // ]);

        $userPin = $request->d1 . $request->d2 . $request->d3 . $request->d4 . $request->d5 . $request->d6;

        if (Session::has('varification_pin')) {
            $pin = Session::get('varification_pin');
            if ($userPin == $pin) {
                $vendor->status = 'active';
                $vendor->save();
                return redirect()->route('vendorProfile', ['vendorName' => $vendor->name]);
            } else {
                return redirect()->route('activation', ['id' => $vendor->id])->with('error', 'invalid code');
            }
        } else {
            return redirect()->route('activation', ['id' => $vendor->id])->with('error', 'Session timed out! Retry');
        }
    }

    public function vendorForgetPassword()
    {
        $user = "vendor";
        return view('forgetPassword', compact('user'));
    }

    public function vendorForgetPasswordSendMail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $user = Vendor::where('email', $validated['email'])->first();
        if (isset($user)) {
            $usertype = "vendor";
            Mail::to($validated['email'])->send(new ForgetPassword($usertype, $user));
            return redirect()->back()->with('success', "Check your Inbox");
        }
        return redirect()->back()->with('error', "No user found with this email");
    }
}

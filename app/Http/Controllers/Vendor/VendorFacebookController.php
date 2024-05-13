<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\FacebookAuthorization;
use App\Models\Vendor\Vendor; // Import if needed
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Env;

class VendorFacebookController extends Controller
{
    //
    public function connectToFacebook()
    {
        $appId = env('FACEBOOK_APP_ID');
        //dd($appId);
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->user();

            // Check if vendor with this Facebook ID exists (optional)
            $vendor = Vendor::where('facebook_id', $user->id)->first();

            if (!$vendor) {
                // Handle case where vendor hasn't signed up yet
                // (create vendor account, prompt for additional details, etc.)
                return redirect()->route('home')->with('message', 'Please create a vendor account first.');
            }

            // Save or update Facebook access token and (optionally) Facebook Page ID
            $authorization = FacebookAuthorization::updateOrCreate(
                ['vendor_id' => $vendor->id],
                [
                    'facebook_access_token' => $user->token,
                    'facebook_page_id' => $user->user['id'], // Optional, if needed
                ]
            );

            // Redirect to a success page or vendor dashboard with confirmation
            return redirect()->route('vendorDashboard',['vendorName' => $venodor->name])->with('message', 'Facebook authorization successful!');
        } catch (\Exception $e) {
            return redirect()->route('vendorDashboard',['vendorName' => $venodor->name])->with('error', 'Facebook authorization failed: ' . $e->getMessage());
        }
    }
}

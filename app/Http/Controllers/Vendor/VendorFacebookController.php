<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor\FacebookAuthorization;
use App\Models\Vendor\Vendor; // Import if needed
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Env;

class VendorFacebookController extends Controller
{
    //
    public function connectToFacebook()
    {
        $appId = config('services.facebook.client_id');

        // dd(Socialite::driver('facebook')->scopes([
        //     'public_profile', 'pages_show_list','pages_read_engagement','pages_manage_posts','pages_manage_metadata', 'user_videos','user_posts'
        // ]));
        return Socialite::driver('facebook')->scopes([
            'public_profile', 'pages_show_list','pages_read_engagement','pages_manage_posts','pages_manage_metadata', 'user_videos','user_posts'
        ])->redirect();

        
    }

    public function handleFacebookCallback(Request $request)
    {
        $vendor = Session::get('vendor');


        $auth_user = Socialite::driver('facebook')->user();
        // dd($auth_user);
        DB::table('vendorFbs')
                    ->where('vendor_id' , $vendor->id)
                    ->update([
                        'token' => $auth_user->token,
                        'facebook_app_id' => $auth_user->id,
                    ]);

            return redirect()->route('vendorProfile');






    //     try {
    //         $user = Socialite::driver('facebook')->user();

    //         // Check if vendor with this Facebook ID exists (optional)
    //         $vendor = Vendor::where('facebook_id', $user->id)->first();

    //         if (!$vendor) {
    //             // Handle case where vendor hasn't signed up yet
    //             // (create vendor account, prompt for additional details, etc.)
    //             return redirect()->route('home')->with('message', 'Please create a vendor account first.');
    //         }

    //         // Save or update Facebook access token and (optionally) Facebook Page ID
    //         $authorization = FacebookAuthorization::updateOrCreate(
    //             ['vendor_id' => $vendor->id],
    //             [
    //                 'facebook_access_token' => $user->token,
    //                 'facebook_page_id' => $user->user['id'], // Optional, if needed
    //             ]
    //         );

    //         // Redirect to a success page or vendor dashboard with confirmation
    //         return redirect()->route('vendorDashboard',['vendorName' => $venodor->name])->with('message', 'Facebook authorization successful!');
    //     } catch (\Exception $e) {
    //         return redirect()->route('vendorDashboard',['vendorName' => $venodor->name])->with('error', 'Facebook authorization failed: ' . $e->getMessage());
    //     }
    }
}

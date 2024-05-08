<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\VendorBankDetails;

class BankDetailsController extends Controller
{
    //
    public function saveBankDetails(Request $request, $id){
        if(Session::has('vendor')){
            $vendor = Vendor::where('id', $id)->first();

            $validated = $request->validate([
                'accountNumber' =>'required',
                'bankName' =>'required',
                'branchName' =>'required',
                'bic' =>'required',
                'iban' =>'required',
                'bankAddress' =>'required',
                'accountName' =>'required',

            ]);

            $bankDetails = VendorBankDetails::where('vendor_id', $vendor->id)->first();

            if(empty($bankDetails)){
                $bankDetails = new VendorBankDetails();
            }

            $bankDetails->account_name = $validated['accountName'];
            $bankDetails->bank_name = $validated['bankName'];
            $bankDetails->account_number = $validated['accountNumber'];
            $bankDetails->branch_name = $validated['branchName'];
            $bankDetails->bic = $validated['bic'];
            $bankDetails->iban = $validated['iban'];
            $bankDetails->bank_address = $validated['bankAddress'];
            $bankDetails->vendor_id = $id;

            $bankDetails->save();

            return redirect()->route('paymentPage',['vendorName' => $vendor->name]);

            

        }else{
            return redirect()->route('home');
        }

    }
}

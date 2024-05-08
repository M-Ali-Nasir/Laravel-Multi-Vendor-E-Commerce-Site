<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\vendor;

class VendorBankDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'account_name',
        'bank_name',
        'account_number',
        'branch_name',
        'bic',
        'iban',
        'bank_address',
         // Include the remember_token field here
    ];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

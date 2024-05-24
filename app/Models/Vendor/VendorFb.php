<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Vendor;

class VendorFb extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'token',
        'facebook_app_id',
        'facebook_page_id',
         // Include the remember_token field here
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

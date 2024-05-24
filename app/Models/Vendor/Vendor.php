<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Store;
use App\Models\Vendor\PaymentMethod;
use App\Models\Vendor\VendorBankDetails;
use App\Models\Vendor\Products\Variations;
use App\Models\Vendor\Products\Product_categories;
use App\Models\Vendor\FacebookAuthorization;
use App\Models\Vendor\VendorFb;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
         // Include the remember_token field here
    ];

    public function facebookAuthorization()
    {
        return $this->hasOne(FacebookAuthorization::class);
    }

    public function vendorFb()
    {
        return $this->hasOne(VendorFb::class);
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentMethod::class);
    }
    public function bankDetails()
    {
        return $this->hasMany(VendorBankDetails::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function variations()
    {
        return $this->hasMany(Variations::class);
    }

    public function product_categories()
    {
        return $this->hasMany(Product_categories::class);
    }
}

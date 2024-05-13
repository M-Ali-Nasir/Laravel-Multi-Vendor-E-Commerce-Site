<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookAuthorization extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'facebook_access_token',
        'facebook_page_id', // Optional, if needed for specific posting logic
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}

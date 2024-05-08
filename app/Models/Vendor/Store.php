<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Products\Product;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'vendor_id',
        'slogan',
        'description',
        'phone',
        'address',
        'opening-day',
        'closing-day',
        'opening-time',
        'closing-time',
        'p-heading',
        'p-subheading',
        'c-heading',
        'c-subheading', // Include the remember_token field here
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\Customer;
use App\Models\Vendor\Products\Product;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'product_id',
        'customer_id',
        'quantity',
        'price', // Include the remember_token field here
    ];
    public function user()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}

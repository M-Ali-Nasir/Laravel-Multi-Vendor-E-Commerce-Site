<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Order;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'payment_method',
         // Include the remember_token field here
    ];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_payment');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

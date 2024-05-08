<?php

namespace App\Models\Vendor\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Products\variations;
use App\Models\Vendor\Products\Product_categories;
use App\Models\Vendor\Store;
use App\Models\Vendor\PaymentMethod;
use App\Models\Vendor\Order;
use App\Models\User\Cart;

class Product extends Model
{
    use HasFactory;

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function category()
    {
        return $this->belongsTo(Product_categories::class);
    }


    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    

    public function variations()
    {
        return $this->belongsToMany(Variations::class, 'product_variation', 'product_id', 'variation_id')
                    ->withPivot('quantity', 'price_modifier','image');
    }

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, 'product_payment');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    
}

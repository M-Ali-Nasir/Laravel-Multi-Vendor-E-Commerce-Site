<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Order;
use App\Models\User\Cart;
use App\Models\Vendor\Products\ProductReview;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        '', // Include the remember_token field here
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}

<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Vendor;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Products\Variations;
use App\Models\Vendor\paymentMethod;
use App\Models\User\Customer;
use App\Models\Vendor\OrderHistory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'customer_id',
        'product_id',
        'variation_id',
        'payment_method_id',
        'quantity',
    ];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variations::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function orderHistory()
    {
        return $this->hasMany(OrderHistory::class);
    }
}

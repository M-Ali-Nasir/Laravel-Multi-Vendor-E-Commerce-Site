<?php

namespace App\Models\Vendor\Products;

use App\Models\User\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Products\Product;

class ProductReview extends Model
{
    use HasFactory;
    protected $fillable = [
        // Other fillable fields here
        'product_id',
        'customer_id',
        'rating',
        'review',
    ];




    public function products()
    {
        return $this->blongsTo(Product::class);
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
}

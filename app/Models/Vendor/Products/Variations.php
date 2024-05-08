<?php

namespace App\Models\Vendor\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Order;
use App\Models\Vendor\Vendor;

class Variations extends Model
{
    use HasFactory;
    protected $fillable = [
        // Other fillable fields here
        'quantity',
        'price_modifier',
    ];
   

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variation')
                    ->withPivot('quantity', 'price_modifier','image');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function vendors()
    {
        return $this->blongsTo(Vendor::class);
    }
}

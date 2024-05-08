<?php

namespace App\Models\Vendor\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor\Products\Product;
use App\Models\Vendor\Vendor;

class Product_categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
         // Include the remember_token field here
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function vendors()
    {
        return $this->blongsTo(Vendor::class);
    }
}

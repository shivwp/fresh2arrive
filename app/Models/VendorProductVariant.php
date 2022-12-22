<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_product_id',
        'market_price',
        'variant_qty',
        'price',
    ];

}

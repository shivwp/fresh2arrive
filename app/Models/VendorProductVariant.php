<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorProductVariant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vendor_product_id',
        'market_price',
        'variant_qty',
        'price',
    ];
}

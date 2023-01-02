<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorProduct extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'product_id',
        'SKU',
        'name',
        'image',
        'status',
    ];

    public function vendor() {
        return $this->hasOne(User::class, 'id', 'vendor_id');
    }

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    // public function getProductByCategoryId() {
    //     return $this->hasOne(Product::class, 'category_id', 'category_id');
    // }

    public function variants() {
        return $this->hasMany(VendorProductVariant::class, 'vendor_product_id', 'id');
    }
    
}

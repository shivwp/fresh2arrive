<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'SKU',
        'name',
        'qty',
        'qty_type',
        'market_price',
        'regular_price',
        'content',
        'image',
        'status',
    ];

    public function Category() {
        return $this->hasOne(Category::class, 'id','category_id');
    }

    public static function getProductsByCategoryId($category_id = null) {
        return static::where('category_id', $category_id)->get();
    }

    public static function getProductDetailsByID($id = null) {
        return static::where('id', $id)->first();
    }
}

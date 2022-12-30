<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coupon_code',
        'discount_type',
        'total_price',
        'discounted_price',
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

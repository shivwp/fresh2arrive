<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'coupon_code',
        'coupon_details',
        'valid_from',
        'valid_to',
        'discount_type',
        'amount',
        'max_user',
        'max_reedem',
        'max_discount',
        'min_order_value',
        'status'
    ];

    public function vendor() {
        return $this->hasOne(User::class, 'id', 'vendor_id');
    }
}

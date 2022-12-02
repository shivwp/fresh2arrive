<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'coupon_code',
        'item_total',
        'delivery_charges',
        'tip_amount',
        'grand_total',
        'driver_id',
        'commission_driver',
        'commission_admin',
        'status',
    ];
}

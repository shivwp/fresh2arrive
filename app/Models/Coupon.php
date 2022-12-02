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
        'coupon_code',
        'coupon_details',
        'valid_from',
        'valid_to',
        'discount_type',
    ];
}

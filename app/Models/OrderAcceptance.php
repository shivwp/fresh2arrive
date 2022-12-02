<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAcceptance extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'is_pickup',
        'status',
    ];
}

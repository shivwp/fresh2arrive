<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_image',
        'aadhar_no',
        'pan_no',
        'bank_statement',
        'pan_card_image',
        'aadhar_front_image',
        'aadhar_back_image',
        'remark',
        'status',
    ];
}

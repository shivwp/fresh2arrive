<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dob',
        'aadhar_no',
        'pan_no',
        'vehicle_no',
        'licence_no',
        'bank_statement',
        'pan_card_image',
        'licence_front_image',
        'licence_back_image',
        'aadhar_front_image',
        'aadhar_back_image',
        'remark',
        'status',
    ];
}

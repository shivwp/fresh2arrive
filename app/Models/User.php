<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_driver',
        'is_vendor',
        'wallet_balance',
        'name',
        'phone',
        'email',
        'otp',
        'profile_image',
        'latitude',
        'longitude',
        'location',
        'default_address',
        'referal_code',
        'device_token',
        'device_id',
        'is_driver_online',
        'delivery_range',
        'self_delivery',
        'admin_commission',
        'as_driver_verified',
        'as_vendor_verified',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function driver() {
        return $this->hasOne(DriverProfile::class,'user_id');
    }
    
    public function vendor() {
        return $this->hasOne(VendorProfile::class, 'user_id');
    }

    public function vendor_availability() {
        return $this->hasMany(VendorAvailability::class, 'user_id');
    }
    /**
     * Get User Data By Phone no.
     * takes parameter phone no.
     * returns user's data
     */
    public static function findByPhone($phone = null) {
        return static::where('phone', $phone)->first();
    }

    /**
     * Get User Data By Referal Code.
     * takes parameter referal code.
     * returns user's data
     */
    public static function findByReferalCode($referal_code = null) {
        return static::where('referal_code', $referal_code)->first();
    }

    /**
     * Get User Name By Id.
     * takes parameter User id.
     * returns user's name
     */
    public static function getNameById($id) {
        return static::where('id', $id)->first('name');
    }

    /**
     * Get Vendor's Name and Id .
     * 
     * returns vendors's Name and Id
     */
    public static function getVendorNameAndId() {
        return static::where('is_vendor', '=', 1)->pluck('name', 'id');
    }
}

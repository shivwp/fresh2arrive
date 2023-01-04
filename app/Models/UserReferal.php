<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReferal extends Model
{
    use HasFactory;

    protected $fillable = [
        'referred_user_id',
        'user_id',
    ];
}

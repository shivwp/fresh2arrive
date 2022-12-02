<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorProduct extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'SKU',
        'name',
        'image',
        'status',
    ];
    
}

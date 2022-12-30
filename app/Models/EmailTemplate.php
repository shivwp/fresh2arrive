<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'email_key',
        'email_subject',
        'email_content',
        'status',
    ];
    
}

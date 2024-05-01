<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verify_email extends Model
{
    use HasFactory;
    protected $fillable =[
        'email','OTP','userId','created_at','updated_at'
    ];
}

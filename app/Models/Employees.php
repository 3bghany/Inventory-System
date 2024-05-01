<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable =[
        'name','email','phone','address','salary','nid','photo','joining_date'

    ];
    //default value property
    protected $attributes = [
        'photo' => '/backend/img/boy.png',
    ];

}

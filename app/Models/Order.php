<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable =[
        'customer_id','quantity','sub_total','total','payBy','pay','due','order_date','order_month','order_year'
    ];
}

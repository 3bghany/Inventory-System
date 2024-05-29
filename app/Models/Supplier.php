<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// use Laravel\Scout\Searchable;

class Supplier extends Model
{
    use HasFactory;
    // use Searchable;
    protected $fillable =[
        'name','email','phone','address','photo','shopname'

    ];
    //default value property
    protected $attributes = [
        'photo' => '/backend/img/boy.png',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'supplier_id');
    }
}

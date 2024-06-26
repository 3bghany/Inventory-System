<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
class Product extends Model
{
    use HasFactory,Searchable;
    protected $fillable =[
        'category_id','name','code','root','buying_price','selling_price','supplier_id',
        'buying_date','photo','quantity'
    ];
    //default value property
    protected $attributes = [
        'photo' => '/backend/img/product.png',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

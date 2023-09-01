<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable= ['product_id','cart_id'];

    public function cart(){
        return $this->belongsTo(Cart::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}

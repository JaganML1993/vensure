<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    // protected $table = 'cart_products';
    protected $fillable=['user_id','quantity'];

    public function products(){
        return $this->belongsToMany(Product::class, 'cart_products','cart_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

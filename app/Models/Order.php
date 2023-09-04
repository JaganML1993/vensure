<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','total_items','total'];
    
    public function products(){
        return $this->belongsToMany(Product::class, 'order_items','order_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}

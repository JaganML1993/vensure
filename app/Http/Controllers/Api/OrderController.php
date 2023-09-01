<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('client')){
            return response()->json(['data' =>Auth::user()->orders()->with('products')->get()]);
        }else{
            return response()->json(['data' => Order::with('users','products')->get()]);
        }
    }

    public function update(Order $order){
        $order->status = 'delivered';
        $order->save();
        return response()->json(['message' => 'Order status changed successfully'], Response::HTTP_OK);
    }

    public function placeOrder(){
        $cart = Cart::first();
        $cartProducts = $cart->products();
        $order = Auth::user()->orders()->create([
            'total_items' => $cart->total_items,
            'total' => $cartProducts->sum('price'),
        ]);

        $order->products()->sync($cartProducts->pluck('product_id')->all());
        $cart->delete();
        return response()->json(['message' => 'Order placed successfully.'], Response::HTTP_OK);
    }
}

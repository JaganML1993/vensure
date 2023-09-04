<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ItemNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Auth::user()->cart()->with('products')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartRequest $request)
    {
        $product = Product::find($request->get('product_id'));
        if ($product) {
            $cart = Auth::user()->cart()->first();
            if($cart){
                $cart->total_items = $cart ? $cart->total_items+1 : 1;
                $cart->save();
            }else
                $cart = Auth::user()->cart()->create(['total_items'=> 1]);            
            
            $cart->products()->attach([$request->get('product_id')]);
            return response()->json(['message' => 'Added in cart successfully.'], Response::HTTP_CREATED);
        } else
            return response()->json(['message' => 'Product not found']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCartRequest  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::group(['middleware' => ['role:client']], function(){
        Route::apiResource('products', ProductController::class)->only('index','show');
        Route::apiResource('cart', CartController::class);
        Route::post('place-order', [OrderController::class, 'placeOrder']);
        Route::get('user-detail',[UserController::class, 'userDetail']);
        // Route::apiResource('orders', OrderController::class)->only('index');
        Route::apiResource('users', UserController::class)->only('update');
    });

    Route::group(['middleware' => ['role:admin']], function(){
        Route::apiResource('products', ProductController::class);
        Route::apiResource('users', UserController::class);
    });
    Route::apiResource('orders', OrderController::class);
    
    // Route::apiResource('orders', OrderController::class)->only('index');
    
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
  
Route::post('/registers',[ApiController::class,'registerIndex']);


Route::post('inquiries', [ApiController::class, 'indexInquiry']);
Route::post('carts', [ApiController::class, 'cart']);
Route::get('/single-user-cart/{id}', [ApiController::class, 'singleUserCart']);

Route::put('/updatecart/{id}', [ApiController::class, 'updateCartItem']);
Route::delete('/deletecarts/{id}', [ApiController::class, 'deleteCartItem']);
Route::get('getCarts', [ApiController::class, 'getCart']);
Route::get('categories', [ApiController::class, 'categoryIndex']);
Route::get('singlecategory/{id}',[ApiController::class,'categorysingle']);
Route::get('abouts', [ApiController::class, 'aboutIndex']);

Route::post('order', [ApiController::class, 'order']);
Route::get('getOrder', [ApiController::class, 'getOrder']);


Route::get('getproduct', [ApiController::class, 'productsIndex']);
Route::get('getsingleproduct/{id}', [ApiController::class, 'productSingle']);
// In routes/api.php or routes/web.php
// Route::delete('/cart/{id}', [ApiController::class, 'destroy']);



Route::post('signup', [AuthController::class, 'signup']);
Route::post('signin', [AuthController::class, 'signin']);
Route::post('signout', [AuthController::class, 'signout'])->middleware('auth:sanctum');
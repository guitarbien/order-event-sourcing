<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->post('/users', function (Request $request) {
    \App\User::create($request->all());
    return new \Illuminate\Http\JsonResponse([], 201);
});

Route::resource('orders', OrderController::class);
// Route::get('transactions', [TransactionsController::class, 'index']);
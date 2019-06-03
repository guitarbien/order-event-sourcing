<?php

use App\User;
use Illuminate\Http\JsonResponse;
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

Route::middleware('api')->get('/users/{user}', function (App\User $user) {
    return new JsonResponse([
        'id'    => $user->id,
        'name'  => $user->name,
        'email' => $user->email,
    ], 200);
});

Route::middleware('api')->post('/users', function (Request $request) {
    User::create($request->all());
    return new JsonResponse([], 201);
});

Route::resource('orders', 'OrderController');
// Route::get('transactions', [TransactionsController::class, 'index']);

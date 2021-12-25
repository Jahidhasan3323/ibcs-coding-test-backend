<?php

use App\Http\Controllers\Api\auth\AuthenticationController;
use App\Http\Controllers\Api\FrontendController;
use App\Http\Controllers\Api\OrderController;
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

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/register', [AuthenticationController::class, 'register']);

Route::get('/products', [FrontendController::class, 'index']);

Route::get('/check-product-stock/{product}', [FrontendController::class, 'checkProductStock']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return response()->json(['valid' => auth()->check()]);
    });
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    //Orders
    Route::get('/order', [OrderController::class, 'index']);
    Route::post('/order', [OrderController::class, 'store']);
    Route::get('/order/{id}', [OrderController::class, 'show']);
});




<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\DeliveredOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('admin', [DashboardController::class, 'index'])->name('admin');
Route::group(['middleware' => "auth:web"], function () {
    // product for admin
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/create', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [ProductController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // order for admin
    Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        Route::get('/update-status/{orderId}/{status}', [\App\Http\Controllers\Api\OrderController::class, 'updateOrderStatus'])
            ->name('update.status');
    });
    // order for admin
    Route::group(['prefix' => 'delivered-order', 'as' => 'delivered.order.'], function () {
        Route::get('/', [DeliveredOrderController::class, 'index'])->name('');
        Route::get('/show/{id}', [DeliveredOrderController::class, 'show'])->name('show');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', function () {
        return view('backend.pages.dashboard.index');
    })->name('dashboard');
});
Auth::routes([
    'register' => false,
    'login'    => true,
]);

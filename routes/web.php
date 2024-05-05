<?php
use App\Http\Middleware\Admin;
use App\Http\Middleware\User;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware([User::class])->group(function () {
});

Route::get('/csrf', function () {
        $csrfToken = csrf_token();
    return Response::json(['csrf_token' => $csrfToken]);
});


Route::get('/penggunas', [PenggunaController::class, 'index']);
Route::get('/penggunas/{id}', [PenggunaController::class, 'show']);
Route::delete('/penggunas/{id}', [PenggunaController::class, 'destroy']);
Route::get('/pengguna/datatables', [PenggunaController::class, 'getdata']);
Route::post('/penggunas/{id}', [PenggunaController::class, 'update']);
Route::get('/product/datatables', [ProductController::class, 'getdata']);

Route::middleware([User::class])->group(function () {
});

Route::middleware(['admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/getdata', [DashboardController::class, 'getdata']);
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product/{id}', [ProductController::class, 'show']);
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::post('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/datatables', [CategoryController::class, 'getdata']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);


    Route::get('/admin', [UserController::class, 'index']);
    Route::get('/admin/datatables', [UserController::class, 'getdata']);
    Route::get('/admin/{id}', [UserController::class, 'show']);
    Route::post('/admin', [UserController::class, 'store']);
    Route::put('/admin/{id}', [UserController::class, 'update']);
    Route::delete('/admin/{id}', [UserController::class, 'destroy']);

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/datatables', [OrderController::class, 'getdata'])->name('orders.data');

require __DIR__.'/auth.php';

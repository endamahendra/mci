<?php

use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product/datatables', [ProductController::class, 'getdata']);
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

    Route::get('/customer', [CustomerController::class, 'index']);
    Route::get('/customer/datatables', [CustomerController::class, 'getdata']);
    Route::get('/customer/{id}', [CustomerController::class, 'show']);
    Route::post('/customer', [CustomerController::class, 'store']);
    Route::put('/customer/{id}', [CustomerController::class, 'update']);
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);

    Route::get('/supplier', [SupplierController::class, 'index']);
    Route::get('/supplier/datatables', [SupplierController::class, 'getdata']);
    Route::get('/supplier/{id}', [SupplierController::class, 'show']);
    Route::post('/supplier', [SupplierController::class, 'store']);
    Route::put('/supplier/{id}', [SupplierController::class, 'update']);
    Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']);

    Route::get('/purchaseorder', [PurchaseOrderController::class, 'index']);
    Route::get('/purchaseorder/datatables', [PurchaseOrderController::class, 'getdata']);
    Route::get('/purchaseorder/{id}', [PurchaseOrderController::class, 'show']);
    Route::post('/purchaseorder', [PurchaseOrderController::class, 'store']);
    Route::put('/purchaseorder/{id}', [PurchaseOrderController::class, 'update']);
    Route::delete('/purchaseorder/{id}', [PurchaseOrderController::class, 'destroy']);

    Route::get('/salesorder', [SalesOrderController::class, 'index']);
    Route::get('/salesorder/datatables', [SalesOrderController::class, 'getdata']);
    Route::get('/salesorder/{id}', [SalesOrderController::class, 'show']);
    Route::post('/salesorder', [SalesOrderController::class, 'store']);
    Route::put('/salesorder/{id}', [SalesOrderController::class, 'update']);
    Route::delete('/salesorder/{id}', [SalesOrderController::class, 'destroy']);

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/datatables', [UserController::class, 'getdata']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    Route::get('/penduduk', [PendudukController::class, 'index']);
    Route::get('/penduduk/datatables', [PendudukController::class, 'getdata']);
    Route::get('/penduduk/{id}', [PendudukController::class, 'show']);
    Route::post('/penduduk', [PendudukController::class, 'store']);
    Route::put('/penduduk/{id}', [PendudukController::class, 'update']);
    Route::delete('/penduduk/{id}', [PendudukController::class, 'destroy']);
});

require __DIR__.'/auth.php';

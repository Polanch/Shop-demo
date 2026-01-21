<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('home');
});

Route::get('/consumer/dashboard', function () {
    $products = \App\Models\Product::where('product_status', 'Available')->get();
    return view('consumer_dashboard', compact('products'));
});
Route::post('/consumer/checkout', [CheckoutController::class, 'checkout'])->name('consumer.checkout');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

Route::get('/admin/users', function () {
    return view('admin_users');
})->name('admin.users');

Route::get('/admin/sales', function () {
    return view('admin_sales');
})->name('admin.sales');


Route::post('/admin/users', [UserController::class, 'store']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products');
Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('home');
});

Route::get('/consumer/dashboard', function () {
    return view('consumer_dashboard');
});

Route::get('/admin/dashboard', function () {
    return view('admin_dashboard');
})->name('admin.dashboard');

Route::get('/admin/products', function () {
    return view('admin_products');
})->name('admin.products');

Route::get('/admin/orders', function () {
    return view('admin_orders');
})->name('admin.orders');

Route::get('/admin/users', function () {
    return view('admin_users');
})->name('admin.users');

Route::get('/admin/sales', function () {
    return view('admin_sales');
})->name('admin.sales');


Route::post('/admin/users', [UserController::class, 'store']);
Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products');
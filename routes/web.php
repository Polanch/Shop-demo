<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SalesController;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/admin/users', [UserController::class, 'store']);

// Consumer routes - protected by role middleware
Route::middleware(['role:Consumer'])->group(function () {
    Route::get('/consumer/dashboard', function () {
        $products = \App\Models\Product::where('product_status', 'Available')->get();
        return view('consumer_dashboard', compact('products'));
    })->name('consumer.dashboard');
    
    Route::post('/consumer/checkout', [CheckoutController::class, 'checkout'])->name('consumer.checkout');
});

// Admin routes - protected by role middleware
Route::middleware(['role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
    
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::put('/admin/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    
    Route::get('/admin/sales', [SalesController::class, 'index'])->name('admin.sales');
    
    Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});

// Logout route - accessible to all authenticated users
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;

// Authentication routes
Auth::routes();

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Products
Route::resource('products', ProductController::class)->middleware('auth');

// Categories
Route::resource('categories', CategoryController::class)->middleware('auth');

// Orders
Route::resource('orders', OrderController::class)->middleware('auth');

// Reports
Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales')->middleware('auth');
Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory')->middleware('auth');
Route::get('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate')->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

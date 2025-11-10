<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\StockBatchController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('stock-batches', StockBatchController::class)->names([
    'index' => 'stock_batches.index',
]);

Route::resource('warehouses', WarehouseController::class)->names([
    'index' => 'warehouses.index',
]);

Route::resource('transactions', TransactionController::class)->names([
    'index' => 'transactions.index',
]);

Route::resource('products', ProductController::class)->names([
    'index' => 'products.index',
]);

Route::resource('product-categories', ProductCategoryController::class)->names(names: [
    'index' => 'product_categories.index',
]);

Route::resource('product-units', ProductUnitController::class)->names([
    'index' => 'product_units.index',
]);

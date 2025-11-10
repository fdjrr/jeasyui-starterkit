<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('sales-orders', SalesOrderController::class)->names([
    'index' => 'sales_orders.index',
]);

Route::resource('purchase-orders', PurchaseOrderController::class)->names([
    'index' => 'purchase_orders.index',
]);

Route::resource('warehouses', WarehouseController::class)->names([
    'index' => 'warehouses.index',
]);

Route::resource('warehouses', WarehouseController::class)->names([
    'index' => 'warehouses.index',
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

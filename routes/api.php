<?php

use App\Http\Controllers\Api\v1\ProductCategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\ProductUnitController;
use App\Http\Controllers\Api\v1\PurchaseOrderController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\WarehouseController;

Route::prefix('v1')->group(function () {
    Route::apiResource('purchase-orders', PurchaseOrderController::class)->names([
        'index' => 'api.v1.purchase-orders.index',
        'store' => 'api.v1.purchase-orders.store',
        'update' => 'api.v1.purchase-orders.update',
        'destroy' => 'api.v1.purchase-orders.destroy',
    ]);

    Route::apiResource('warehouses', WarehouseController::class)->names([
        'index' => 'api.v1.warehouses.index',
        'store' => 'api.v1.warehouses.store',
        'update' => 'api.v1.warehouses.update',
        'destroy' => 'api.v1.warehouses.destroy',
    ]);

    Route::apiResource('products', ProductController::class)->names([
        'index' => 'api.v1.products.index',
        'store' => 'api.v1.products.store',
        'update' => 'api.v1.products.update',
        'destroy' => 'api.v1.products.destroy',
    ]);

    Route::apiResource('product-categories', ProductCategoryController::class)->names([
        'index' => 'api.v1.product_categories.index',
        'store' => 'api.v1.product_categories.store',
        'update' => 'api.v1.product_categories.update',
        'destroy' => 'api.v1.product_categories.destroy',
    ]);

    Route::apiResource('product-units', ProductUnitController::class)->names([
        'index' => 'api.v1.product_units.index',
        'store' => 'api.v1.product_units.store',
        'update' => 'api.v1.product_units.update',
        'destroy' => 'api.v1.product_units.destroy',
    ]);

    Route::apiResource('users', UserController::class)->names([
        'index' => 'api.v1.users.index',
        'store' => 'api.v1.users.store',
        'update' => 'api.v1.users.update',
        'destroy' => 'api.v1.users.destroy',
    ]);
});

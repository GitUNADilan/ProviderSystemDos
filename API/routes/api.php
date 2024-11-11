<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    // Rutas del módulo de Productos
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::get('/show/{id}', [ProductController::class, 'show']);
    });

    // Rutas del módulo de Usuarios
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::get('/show/{id}', [UserController::class, 'show']);
    });

    // Rutas del módulo de empleados
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index']);
        Route::post('/', [EmployeeController::class, 'store']);
        Route::delete('/{id}', [EmployeeController::class, 'destroy']);
        Route::put('/{id}', [EmployeeController::class, 'update']);
        Route::get('/show/{id}', [EmployeeController::class, 'show']);
    });

    // Rutas del módulo de proveedores
    Route::prefix('providers')->group(function () {
        Route::get('/', [ProviderController::class, 'index']);
        Route::post('/', [ProviderController::class, 'store']);
        Route::delete('/{id}', [ProviderController::class, 'destroy']);
        Route::put('/{id}', [ProviderController::class, 'update']);
        Route::get('/show/{id}', [ProviderController::class, 'show']);
    });

    // Rutas del módulo de compras
    Route::prefix('purchases')->group(function () {
        Route::get('/', [PurchaseController::class, 'index']);
        Route::post('/', [PurchaseController::class, 'store']);
        Route::delete('/{id}', [PurchaseController::class, 'cancel']);
        Route::get('/show/{$id}', [PurchaseController::class, 'show']);
    });

    // Rutas del módulo de ventas
    Route::prefix('sales')->group(function () {
        Route::get('/', [SaleController::class, 'index']);
        Route::post('/', [SaleController::class, 'store']);
        Route::delete('/{id}', [SaleController::class, 'cancel']);
        Route::get('/show/{id}', [SaleController::class, 'show']);
    });

    // Rutas de login
    Route::prefix('login')->group(function () {
        Route::post('/', [LoginController::class, 'validateLogin']);
    });
});

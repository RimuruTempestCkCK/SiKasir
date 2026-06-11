<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\KasirController;

// Auth Routes
Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // Admin System Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard']);
        
        // User CRUD
        Route::get('/user', [AdminController::class, 'user']);
        Route::post('/user', [AdminController::class, 'userStore'])->name('admin.user.store');
        Route::put('/user/{id}', [AdminController::class, 'userUpdate'])->name('admin.user.update');
        Route::delete('/user/{id}', [AdminController::class, 'userDelete'])->name('admin.user.delete');

        Route::get('/store', [AdminController::class, 'store']);
    });

    // Pimpinan (Owner) Routes
    Route::middleware(['role:pimpinan'])->prefix('pimpinan')->group(function () {
        Route::get('/', [PimpinanController::class, 'dashboard']);
        Route::get('/store', [PimpinanController::class, 'storeInfo']);
        
        // Product CRUD
        Route::get('/product', [PimpinanController::class, 'product']);
        Route::post('/product', [PimpinanController::class, 'productStore'])->name('pimpinan.product.store');
        Route::put('/product/{id}', [PimpinanController::class, 'productUpdate'])->name('pimpinan.product.update');
        Route::delete('/product/{id}', [PimpinanController::class, 'productDelete'])->name('pimpinan.product.delete');

        // Kasir CRUD
        Route::get('/kasir', [PimpinanController::class, 'kasir']);
        Route::post('/kasir', [PimpinanController::class, 'kasirStore'])->name('pimpinan.kasir.store');
        Route::put('/kasir/{id}', [PimpinanController::class, 'kasirUpdate'])->name('pimpinan.kasir.update');
        Route::delete('/kasir/{id}', [PimpinanController::class, 'kasirDelete'])->name('pimpinan.kasir.delete');

        Route::get('/stock', [PimpinanController::class, 'stock']);
        Route::post('/stock', [PimpinanController::class, 'stockAdd'])->name('pimpinan.stock.add');
        Route::get('/report/transaction', [PimpinanController::class, 'reportTransaction']);
        Route::get('/report/stock', [PimpinanController::class, 'reportStock']);
    });

    // Kasir Routes
    Route::middleware(['role:kasir'])->prefix('kasir')->group(function () {
        Route::get('/', [KasirController::class, 'dashboard']);
        Route::get('/transaction', [KasirController::class, 'transaction']);
        Route::post('/transaction', [KasirController::class, 'transactionStore'])->name('kasir.transaction.store');
        Route::get('/stock', [KasirController::class, 'stock']);
    });

});

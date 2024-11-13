<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RO1AController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/data-customer', [\App\Http\Controllers\CustomerController::class, 'index'])->name('dashboard');
    Route::post('/store-pelanggan', [CustomerController::class, 'store'])->name('store.pelanggan');
    Route::get('/data-customer/{id}/edit', [CustomerController::class, 'edit'])->name('edit.pelanggan');
    Route::put('/data-customer/{id}', [CustomerController::class, 'update'])->name('update.pelanggan');
    Route::delete('/data-customer/{id}', [CustomerController::class, 'destroy'])->name('delete.pelanggan');
    Route::post('/import-pelanggan', [CustomerController::class, 'importExcel'])->name('import.pelanggan');

    Route::prefix('/customer-engagement')->group(function () {
        Route::get('/r01a', [RO1AController::class, 'index'])->name('r01a.index');
        Route::get('/api/r01a', [RO1AController::class, 'getDeliveriesForDataTable']);
        Route::get('/r01a/create', [RO1AController::class, 'create'])->name('r01a.create');
        Route::get('/api/customers', [CustomerController::class, 'getCustomersForSelect2']);
        Route::get('/api/menus', [RO1AController::class, 'getMenusForSelect2']);
        Route::post('/r01a/store', [RO1AController::class, 'store'])->name('r01a.store');
        Route::get('/r01a/{id}', [RO1AController::class, 'show'])->name('r01a.show');
        Route::get('/r01a/data/{id}', [RO1AController::class, 'getDeliveriesData']);


    });
});


require __DIR__ . '/auth.php';

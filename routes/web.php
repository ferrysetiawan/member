<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/data-customer', [\App\Http\Controllers\CustomerController::class, 'index'])->name('dashboard');
    Route::post('/store-pelanggan', [CustomerController::class, 'store'])->name('store.pelanggan');
    Route::get('/data-customer/{id}/edit', [CustomerController::class, 'edit'])->name('edit.pelanggan');
    Route::put('/data-customer/{id}', [CustomerController::class, 'update'])->name('update.pelanggan');
    Route::delete('/data-customer/{id}', [CustomerController::class, 'destroy'])->name('delete.pelanggan');
    Route::post('/import-pelanggan', [CustomerController::class, 'importExcel'])->name('import.pelanggan');
});


require __DIR__ . '/auth.php';

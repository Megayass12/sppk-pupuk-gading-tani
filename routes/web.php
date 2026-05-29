<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\AuthController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', fn() => redirect()->route('supplier.index'));

// Supplier routes
Route::resource('supplier', SupplierController::class)->except(['show']);
Route::post('supplier/import',   [SupplierController::class, 'import'])->name('supplier.import');
Route::get('supplier/export',    [SupplierController::class, 'export'])->name('supplier.export');
Route::get('supplier/template',  [SupplierController::class, 'template'])->name('supplier.template');

// Kriteria / Bobot routes
Route::resource('bobot', KriteriaController::class)->except(['show']);

// Rekomendasi
Route::get('rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
});

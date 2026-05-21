<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BobotController;
use App\Http\Controllers\RekomendasiController;

Route::get('/', fn() => redirect()->route('supplier.index'));

// Supplier routes
Route::resource('supplier', SupplierController::class)->except(['show']);
Route::post('supplier/import',   [SupplierController::class, 'import'])->name('supplier.import');
Route::get('supplier/export',    [SupplierController::class, 'export'])->name('supplier.export');
Route::get('supplier/template',  [SupplierController::class, 'template'])->name('supplier.template');

// Bobot routes
Route::resource('bobot', BobotController::class)->except(['show']);

// Rekomendasi
Route::get('rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');

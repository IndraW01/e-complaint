<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Master
    Route::prefix('/master')->name('master.')->group(function () {
        Route::get('/kategori/datatable', [KategoriController::class, 'datatable'])->name('kategori.datatable');
        Route::post('/kategori/slug', [KategoriController::class, 'slug'])->name('kategori.slug');
        Route::resource('/kategori', KategoriController::class)->names('kategori');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\All\PengaduanController as AllPengaduanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Mahasiswa\PengaduanController as MahasiswaPengaduanController;
use App\Http\Controllers\Master\JurusanController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Master\MahasiswaController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\All\ProfileController;
use App\Http\Controllers\Master\ChartController;
use App\Http\Controllers\Master\PengaduanNotificationController;
use App\Models\Mahasiswa;

// Landing Page
Route::get('/', function () {
    $mahasiswas = Mahasiswa::query()->with('jurusans')->get();
    return view('pdd.index', [
        'mahasiswas' => $mahasiswas
    ]);
})->name('landing');

// Dashboard
Route::get('/dashboard', DashboardController::class)->name('dashboard')->middleware('auth:web');

// Chart
Route::get('/chart-pengaduan', ChartController::class)->name('chartPengaduan')->middleware(['auth:web', 'adminSuper:Superadmin, Admin']);
Route::get('/chart/tahun/{tahun}', [ChartController::class, 'chartTahun'])->name('chartPengaduan.tahun')->middleware(['auth:web', 'adminSuper:Superadmin, Admin']);
Route::get('/chart/bulan/{bulan}', [ChartController::class, 'chartBulan'])->name('chartPengaduan.bulan')->middleware(['auth:web', 'adminSuper:Superadmin, Admin']);

// Guard Admin & Staff
Route::middleware(['auth:web', 'adminSuper:Superadmin, Admin'])->group(function () {

    // Master
    Route::prefix('/master')->name('master.')->group(function () {
        // Kategori
        Route::post('/kategori/slug', [KategoriController::class, 'slug'])->name('kategori.slug');
        Route::resource('/kategori', KategoriController::class)->names('kategori')->scoped(['kategori' => 'slug'])->except('show');

        // Mahasiswa
        Route::get('/mahasiswa/export', [MahasiswaController::class, 'export'])->name('mahasiswa.export');
        Route::get('/mahasiswa/exportable', [MahasiswaController::class, 'exportable'])->name('mahasiswa.exportable');
        Route::resource('/mahasiswa', MahasiswaController::class)->names('mahasiswa')->scoped(['mahasiswa' => 'nim'])->except('show');

        // User
        Route::resource('/user', UserController::class)->names('user')->scoped(['user' => 'id'])->except('show')->middleware('isAdmin');

        // Jurusan
        Route::resource('/jurusan', JurusanController::class)->names('jurusan')->scoped(['jurusan' => 'slug'])->except('show');

        // Role
        Route::get('/role', [RoleController::class, 'index'])->name('role.index');

        // Pengaduan Update Status
        Route::put('/pengaduan/{pengaduan:slug}', [AllPengaduanController::class, 'updateStatus'])->name('pengaduan.update')->withoutMiddleware('adminSuper:Superadmin, Admin');

        // Pengaduan Notification
        Route::put('/pengaduan-notification/{pengaduan_notification}', PengaduanNotificationController::class)->name('pengaduanNotification')->withoutMiddleware('adminSuper:Superadmin, Admin');
    });
});

// Guard Mahasiswa
Route::middleware('auth:mahasiswa')->group(function () {

    // Mahasiswa
    Route::prefix('/mahasiswa')->name('mahasiswa.')->group(function () {
        // Pengaduan Mahasiswa
        Route::resource('/pengaduan-saya', MahasiswaPengaduanController::class)->names('pengaduanSaya')->parameters(['pengaduan-saya' => 'pengaduan'])->scoped(['pengaduan' => 'slug'])->except(['edit', 'update']);
        Route::put('/pengaduan-saya/{pengaduan:slug}', [AllPengaduanController::class, 'updateRating'])->name('pengaduanSaya.update');
        Route::post('/pengaduan-saya/create/token', [MahasiswaPengaduanController::class, 'storeToken'])->name('pengaduanSaya.create.token');
        Route::get('/pengaduan-saya/create/cek-pengaduan', [MahasiswaPengaduanController::class, 'cekPengaduan'])->name('pengaduanSaya.create.cekPengaduan');
    });
});

// Guard Mahasiswa & Admin / Staff
Route::middleware('auth:web,mahasiswa')->group(function () {

    // Pengaduan All
    Route::get('/pengaduan/export', [AllPengaduanController::class, 'export'])->name('pengaduan.export');
    Route::get('/pengaduan/exportable', [AllPengaduanController::class, 'exportable'])->name('pengaduan.exportable');
    Route::resource('/pengaduan', AllPengaduanController::class)->names('pengaduan')->scoped(['pengaduan' => 'slug'])->only(['index', 'show']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});



require __DIR__ . '/auth.php';

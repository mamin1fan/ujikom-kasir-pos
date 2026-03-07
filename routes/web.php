<?php

use App\Http\Controllers\ProfileController;
use App\Models\Kategori;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuperAdmin\BarangController as SuperAdminBarangController;
use App\Http\Controllers\SuperAdmin\SekolahController as SuperAdminSekolahController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\KelompokKategoriController as AdminKelompokKategoriController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/redirect-role', [RoleController::class, 'redirectByRole'])
    ->middleware('auth');


Route::prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/', [SuperAdminBarangController::class, 'index'])
        ->name('barang.index');
    Route::post('/store', [SuperAdminBarangController::class, 'store'])
        ->name('barang.store');
    Route::put('/update/{id}', [SuperAdminBarangController::class, 'update'])
        ->name('barang.update');
    Route::delete('/destroy/{id}', [SuperAdminBarangController::class, 'destroy'])
        ->name('barang.destroy');
    Route::get('/sekolah', [SuperAdminSekolahController::class, 'index'])
        ->name('sekolah.index');
    Route::post('/sekolah/store', [SuperAdminSekolahController::class, 'store'])
        ->name('sekolah.store');
    Route::put('/sekolah/update/{id}', [SuperAdminSekolahController::class, 'update'])
        ->name('sekolah.update');
    Route::put('/sekolah/{id}/status', [SuperAdminSekolahController::class, 'updateStatus'])->name('sekolah.status');
});



Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // CRUD Barang
        Route::get('barang', [AdminBarangController::class, 'index'])->name('barang.index');
        Route::get('barang/create', [AdminBarangController::class, 'create'])->name('barang.create');
        Route::post('barang', [AdminBarangController::class, 'store'])->name('barang.store');
        Route::get('barang/{id}/edit', [AdminBarangController::class, 'edit'])->name('barang.edit');
        Route::put('barang/{id}', [AdminBarangController::class, 'update'])->name('barang.update');
        Route::delete('barang/{id}', [AdminBarangController::class, 'destroy'])->name('barang.destroy');
        
        // CRUD Kategori
        Route::get('kategori', [AdminKategoriController::class, 'index'])->name('kategori.index');
        Route::get('kategori/create', [AdminKategoriController::class, 'create'])->name('kategori.create');
        Route::post('kategori', [AdminKategoriController::class, 'store'])->name('kategori.store');
        Route::get('kategori/{id}/edit', [AdminKategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('kategori/{id}', [AdminKategoriController::class, 'update'])->name('kategori.update');
        Route::delete('kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('kategori.destroy');
        
        // CRUD Kelompok Kategori
        Route::get('kelompok-kategori', [AdminKelompokKategoriController::class, 'index'])->name('kelompok-kategori.index');
        Route::get('kelompok-kategori/create', [AdminKelompokKategoriController::class, 'create'])->name('kelompok-kategori.create');
        Route::post('kelompok-kategori', [AdminKelompokKategoriController::class, 'store'])->name('kelompok-kategori.store');
        Route::get('kelompok-kategori/{id}/edit', [AdminKelompokKategoriController::class, 'edit'])->name('kelompok-kategori.edit');
        Route::put('kelompok-kategori/{id}', [AdminKelompokKategoriController::class, 'update'])->name('kelompok-kategori.update');
        Route::delete('kelompok-kategori/{id}', [AdminKelompokKategoriController::class, 'destroy'])->name('kelompok-kategori.destroy');


    });
});


Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir', function () {
        return view('role.kasir.dashboard');
    });
});

require __DIR__ . '/auth.php';

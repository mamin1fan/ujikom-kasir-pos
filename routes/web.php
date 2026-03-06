<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuperAdmin\BarangController as SuperAdminBarangController;
use App\Http\Controllers\SuperAdmin\SekolahController as SuperAdminSekolahController;


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
    Route::get('/admin', function () {
        return view('role.admin.dashboard');
    });
});


Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir', function () {
        return view('role.kasir.dashboard');
    });
});

require __DIR__ . '/auth.php';

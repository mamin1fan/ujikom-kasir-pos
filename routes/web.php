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
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;
use App\Http\Controllers\Admin\KelompokPelangganController as AdminKelompokPelangganController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TransaksiPembelianController as AdminTransaksiPembelianController;
use App\Http\Controllers\Admin\LaporanPembelianController as AdminLaporanPembelianController;




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

        // CRUD Pelanggan
        Route::get('pelanggan', [AdminPelangganController::class, 'index'])->name('pelanggan.index');
        Route::get('pelanggan/create', [AdminPelangganController::class, 'create'])->name('pelanggan.create');
        Route::post('pelanggan', [AdminPelangganController::class, 'store'])->name('pelanggan.store');
        Route::get('pelanggan/{id}/edit', [AdminPelangganController::class, 'edit'])->name('pelanggan.edit');
        Route::put('pelanggan/{id}', [AdminPelangganController::class, 'update'])->name('pelanggan.update');
        Route::delete('pelanggan/{id}', [AdminPelangganController::class, 'destroy'])->name('pelanggan.destroy');

        // CRUD Kelompok Pelanggan
        Route::get('kelompok-pelanggan', [AdminKelompokPelangganController::class, 'index'])->name('kelompok-pelanggan.index');
        Route::get('kelompok-pelanggan/create', [AdminKelompokPelangganController::class, 'create'])->name('kelompok-pelanggan.create');
        Route::post('kelompok-pelanggan', [AdminKelompokPelangganController::class, 'store'])->name('kelompok-pelanggan.store');
        Route::get('kelompok-pelanggan/{id}/edit', [AdminKelompokPelangganController::class, 'edit'])->name('kelompok-pelanggan.edit');
        Route::put('kelompok-pelanggan/{id}', [AdminKelompokPelangganController::class, 'update'])->name('kelompok-pelanggan.update');
        Route::delete('kelompok-pelanggan/{id}', [AdminKelompokPelangganController::class, 'destroy'])->name('kelompok-pelanggan.destroy');

        // CRUD Kelompok Pelanggan
        Route::get('supplier', [AdminSupplierController::class, 'index'])->name('supplier.index');
        Route::get('supplier/create', [AdminSupplierController::class, 'create'])->name('supplier.create');
        Route::post('supplier', [AdminSupplierController::class, 'store'])->name('supplier.store');
        Route::get('supplier/{id}/edit', [AdminSupplierController::class, 'edit'])->name('supplier.edit');
        Route::put('supplier/{id}', [AdminSupplierController::class, 'update'])->name('supplier.update');
        Route::delete('supplier/{id}', [AdminSupplierController::class, 'destroy'])->name('supplier.destroy');

        // CRUD User
        Route::get('user', [AdminUserController::class, 'index'])->name('user.index');
        Route::get('user/create', [AdminUserController::class, 'create'])->name('user.create');
        Route::post('user', [AdminUserController::class, 'store'])->name('user.store');
        Route::get('user/{id}/edit', [AdminUserController::class, 'edit'])->name('user.edit');
        Route::put('user/{id}', [AdminUserController::class, 'update'])->name('user.update');
        Route::delete('user/{id}', [AdminUserController::class, 'destroy'])->name('user.destroy');

        // CRUD Laporan Pembelian
        Route::get('transaksi-pembelian', [AdminTransaksiPembelianController::class, 'index'])->name('transaksi-pembelian.index');
        Route::get('transaksi-pembelian/create', [AdminTransaksiPembelianController::class, 'create'])->name('transaksi-pembelian.create');
        Route::post('transaksi-pembelian', [AdminTransaksiPembelianController::class, 'store'])->name('transaksi-pembelian.store');
        Route::get('transaksi-pembelian/{id}/edit', [AdminTransaksiPembelianController::class, 'edit'])->name('transaksi-pembelian.edit');
        Route::put('transaksi-pembelian/{id}', [AdminTransaksiPembelianController::class, 'update'])->name('transaksi-pembelian.update');
        Route::delete('transaksi-pembelian/{id}', [AdminTransaksiPembelianController::class, 'destroy'])->name('transaksi-pembelian.destroy');


        // CRUD Laporan Pembelian
        Route::get('laporan-pembelian', [AdminLaporanPembelianController::class, 'laporanPembelian'])->name('laporan-pembelian.index');
        Route::get('laporan-pembelian/print', [AdminLaporanPembelianController::class, 'printPembelian'])->name('laporan-pembelian.print');





    });
});


Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir', function () {
        return view('role.kasir.dashboard');
    });
});

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use App\Models\Kategori;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\SuperAdmin\BarangController as SuperAdminBarangController;
use App\Http\Controllers\SuperAdmin\SekolahController as SuperAdminSekolahController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\SuperAdminController as SuperAdminMonitoringController;
use App\Http\Controllers\RestoreController as SuperAdminRestoreController;

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
use App\Http\Controllers\Admin\LaporanStokController as AdminLaporanStokController;

use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Kasir\TransaksiController as KasirTransaksiController;
use App\Http\Controllers\Kasir\QrisController as KasirQrisController;
use App\Http\Controllers\Kasir\LaporanPenjualanController as KasirLaporanPenjualanController;
use App\Http\Controllers\Kasir\CetakStrukController as KasirCetakStrukController;
use App\Http\Controllers\Kasir\LaporanProdukController as KasirLaporanProdukController;
use App\Http\Controllers\Kasir\LaporanKasirController as KasirLaporanKasirController;
use App\Http\Controllers\Kasir\RekapHarianController as KasirRekapHarianController;



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
Route::get('/operasional/dashboard', [SuperAdminMonitoringController::class, 'dashboard'])->name('panel.operasional');
Route::get('/redirect-role', [RoleController::class, 'redirectByRole'])
    ->middleware('auth');

Route::middleware(['auth', 'role:super admin'])->group(function () {
    Route::prefix('super-admin')->name('super-admin.')->group(function () {

        Route::get('/super-admin/pantau/{id}', [SuperAdminMonitoringController::class, 'pantau'])
            ->name('pantau');

        // // set sekolah yang dipantau
        // Route::get('/monitoring/{id}', [SuperAdminMonitoringController::class, 'setMonitoring'])
        //     ->name('monitoring.set');

        // // halaman monitoring
        // Route::get('/monitoring', [SuperAdminMonitoringController::class, 'index'])
        //     ->name('monitoring.index');

        // Route::get('/impersonate/{user}', [ImpersonateController::class, 'loginAs'])
        //     ->name('impersonate.login');
        // Route::get('/stop-impersonate', [ImpersonateController::class, 'stop'])
        //     ->name('impersonate.stop');

        Route::get('/', [SuperAdminBarangController::class, 'index'])
            ->name('barang.index');
        Route::post('/store', [SuperAdminBarangController::class, 'store'])
            ->name('barang.store');
        Route::put('/update/{id}', [SuperAdminBarangController::class, 'update'])
            ->name('barang.update');
        Route::delete('/destroy/{id}', [SuperAdminBarangController::class, 'destroy'])
            ->name('barang.destroy');

        Route::get('/sekolah', [SuperAdminSekolahController::class, 'index'])->name('sekolah.index');
        Route::post('/sekolah', [SuperAdminSekolahController::class, 'store'])->name('sekolah.store');
        Route::put('/sekolah/{id}', [SuperAdminSekolahController::class, 'update'])->name('sekolah.update');
        Route::put('/sekolah/{id}/status', [SuperAdminSekolahController::class, 'toggleStatus'])->name('sekolah.status');

        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
            ->name('dashboard');


        // tampil halaman
        Route::get('/user', [SuperAdminUserController::class, 'index'])
            ->name('user.index');
        // tambah user
        Route::post('/user', [SuperAdminUserController::class, 'store'])
            ->name('user.store');
        // update user (edit + toggle status)
        Route::put('/user/{id}', [SuperAdminUserController::class, 'update'])
            ->name('user.update');
        Route::put('/user/{id}/activate', [SuperAdminUserController::class, 'activate'])
            ->name('user.activate');



        Route::prefix('restore')->name('restore.')->group(function () {

            // Route untuk tiap tipe
            Route::get('/barang', [SuperAdminRestoreController::class, 'index'])->name('barang')->defaults('type', 'barang');
            Route::get('/kategori', [SuperAdminRestoreController::class, 'index'])->name('kategori')->defaults('type', 'kategori');
            Route::get('/pelanggan', [SuperAdminRestoreController::class, 'index'])->name('pelanggan')->defaults('type', 'pelanggan');
            Route::get('/pembelian', [SuperAdminRestoreController::class, 'index'])->name('pembelian')->defaults('type', 'pembelian');
            Route::get('/penjualan', [SuperAdminRestoreController::class, 'index'])->name('penjualan')->defaults('type', 'penjualan');
            Route::get('/supplier', [SuperAdminRestoreController::class, 'index'])->name('supplier')->defaults('type', 'supplier');

        });
        Route::get('/restore/{type}', [SuperAdminRestoreController::class, 'index'])
            ->name('restore.index');
        Route::post('/restore/{type}/{id}', [SuperAdminRestoreController::class, 'restore'])
            ->name('restore.restore');
        Route::delete('/restore/{type}/{id}', [SuperAdminRestoreController::class, 'forceDelete'])
            ->name('restore.forceDelete');


    });
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

        // Laporan Stok
        Route::get('laporan-stok', [AdminLaporanStokController::class, 'stok'])
            ->name('laporan.stok');
        Route::get('laporan-stok/excel', [AdminLaporanStokController::class, 'exportExcel'])
            ->name('laporan.stok.excel');
        Route::get('laporan-stok/pdf', [AdminLaporanStokController::class, 'exportPdf'])
            ->name('laporan.stok.pdf');

        // Menu Kasir
        Route::get('/laporan/produk', [KasirLaporanProdukController::class, 'laporanProduk'])
            ->name('laporan.produk');
        Route::get('/laporan/produk/export', [KasirLaporanProdukController::class, 'export'])
            ->name('laporan.produk.export');
        Route::get('/rekap/harian', [KasirRekapHarianController::class, 'rekapHarian'])
            ->name('rekap.harian');
    });
});


Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/', [KasirDashboardController::class, 'index'])->name('dashboard');

        Route::get('/transaksi', [KasirTransaksiController::class, 'index'])->name('transaksi');

        // Qris Dinamis
        Route::post('/qris/generate', [KasirQrisController::class, 'generate']);
        Route::post('/qris/callback', [KasirQrisController::class, 'callback'])->name('qris.callback');

        // Simpan transaksi
        Route::post('/simpan-transaksi', [KasirTransaksiController::class, 'simpanTransaksi'])->name('simpan-transaksi');

        Route::get('/penjualan', [KasirLaporanPenjualanController::class, 'index'])
            ->name('penjualan');
        Route::get('/kasir/penjualan/cetak', [KasirLaporanPenjualanController::class, 'cetak'])
            ->name('penjualan.cetak');

        Route::get('/cetak-struk', [KasirCetakStrukController::class, 'index'])
            ->name('cetak-struk');
        Route::get('/cetak-struk/{id}', [KasirCetakStrukController::class, 'struk']);


        Route::get('/laporan/produk', [KasirLaporanProdukController::class, 'laporanProduk'])
            ->name('laporan.produk');

        Route::get('/laporan/produk/export', [KasirLaporanProdukController::class, 'export'])
            ->name('laporan.produk.export');

        Route::get('/laporan/kasir', [KasirLaporanKasirController::class, 'laporanKasir'])
            ->name('laporan.kasir');

        Route::get('/rekap/harian', [KasirRekapHarianController::class, 'rekapHarian'])
            ->name('rekap.harian');
    });
});

Route::get('/super-admin/keluar-mode', function () {
    session()->forget([
        'mode',
        'impersonate',
        'impersonator_role',
        'id_sekolah',
        'nama_sekolah'
    ]);

    return redirect()->route('super-admin.dashboard');
})->name('super-admin.keluar-mode');

require __DIR__ . '/auth.php';

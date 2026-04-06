<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;

// Import Controller
use App\Http\Controllers\SuperAdmin\{
    DashboardController as SuperAdminDashboardController,
    BarangController as SuperAdminBarangController,
    SekolahController as SuperAdminSekolahController,
    UserController as SuperAdminUserController,
    SuperAdminController as SuperAdminMonitoringController,
};

use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    BarangController as AdminBarangController,
    KategoriController as AdminKategoriController,
    KelompokKategoriController as AdminKelompokKategoriController,
    PelangganController as AdminPelangganController,
    KelompokPelangganController as AdminKelompokPelangganController,
    SupplierController as AdminSupplierController,
    UserController as AdminUserController,
    TransaksiPembelianController as AdminTransaksiPembelianController,
    LaporanPembelianController as AdminLaporanPembelianController,
    LaporanStokController as AdminLaporanStokController,
};

use App\Http\Controllers\Kasir\{
    DashboardController as KasirDashboardController,
    TransaksiController as KasirTransaksiController,
    QrisController as KasirQrisController,
    LaporanPenjualanController as KasirLaporanPenjualanController,
    CetakStrukController as KasirCetakStrukController,
    LaporanProdukController as KasirLaporanProdukController,
    LaporanKasirController as KasirLaporanKasirController,
    RekapHarianController as KasirRekapHarianController,
};
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\RestoreController as SuperAdminRestoreController;


// ====================== AUTHENTICATED ======================
Route::middleware(['auth'])->group(function () { // hapus 'verified'

    Route::get('/redirect-role', [RoleController::class, 'redirectByRole'])
        ->name('redirect-role');

    Route::get('/', function () {
        return redirect()->route('redirect-role');
    });
});

// Profile tetap pakai verified
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================== SUPER ADMIN ======================
Route::middleware(['auth', 'role:super admin'])->group(function () {
    // impersonate mode
    // Operasional
    Route::get('/operasional/dashboard', [SuperAdminMonitoringController::class, 'super.admin.dashboard'])
        ->name('panel.operasional');

    Route::prefix('super-admin')->name('super-admin.')->group(function () {

        Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

        // Barang
        Route::resource('barang', SuperAdminBarangController::class)->except(['show', 'create', 'edit']);

        // Sekolah
        Route::resource('sekolah', SuperAdminSekolahController::class)->except(['show', 'create', 'edit']);
        Route::put('sekolah/{id}/status', [SuperAdminSekolahController::class, 'toggleStatus'])->name('sekolah.status');

        // User
        Route::get('user', [SuperAdminUserController::class, 'index'])->name('user.index');
        Route::post('user', [SuperAdminUserController::class, 'store'])->name('user.store');
        Route::put('user/{id}', [SuperAdminUserController::class, 'update'])->name('user.update');
        Route::put('user/{id}/activate', [SuperAdminUserController::class, 'activate'])->name('user.activate');

        // Pantau / Monitoring
        Route::get('/pantau/{id}', [SuperAdminMonitoringController::class, 'pantau'])->name('pantau');

        // Restore (Soft Delete)
        Route::prefix('restore')->name('restore.')->group(function () {

            // Route untuk tiap tipe
            Route::get('/barang', [SuperAdminRestoreController::class, 'index'])->name('barang')->defaults('type', 'barang');
            Route::get('/kategori', [SuperAdminRestoreController::class, 'index'])->name('kategori')->defaults('type', 'kategori');
            Route::get('/pelanggan', [SuperAdminRestoreController::class, 'index'])->name('pelanggan')->defaults('type', 'pelanggan');
            Route::get('/pembelian', [SuperAdminRestoreController::class, 'index'])->name('pembelian')->defaults('type', 'pembelian');
            Route::get('/penjualan', [SuperAdminRestoreController::class, 'index'])->name('penjualan')->defaults('type', 'penjualan');
            Route::get('/supplier', [SuperAdminRestoreController::class, 'index'])->name('supplier')->defaults('type', 'supplier');

        });
        Route::prefix('restore')->name('restore.')->group(function () {
            Route::get('/{type}', [SuperAdminRestoreController::class, 'index'])->name('index');
            Route::post('/{type}/{id}', [SuperAdminRestoreController::class, 'restore'])->name('restore');
            Route::delete('/{type}/{id}', [SuperAdminRestoreController::class, 'forceDelete'])->name('forceDelete');
        });

        // Keluar dari Impersonate Mode
        Route::get('/keluar-mode', function () {
            session()->forget([
                'mode',
                'impersonate',
                'impersonator_role',
                'id_sekolah',
                'nama_sekolah'
            ]);
            return redirect()->route('super-admin.dashboard');
        })->name('keluar-mode');
    });
});

// ====================== ADMIN ======================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

     // Laporan & Cetak
    Route::get('/penjualan', [KasirLaporanPenjualanController::class, 'index'])->name('penjualan');
    Route::get('/penjualan/cetak', [KasirLaporanPenjualanController::class, 'cetak'])->name('penjualan.cetak');

    // Resource Routes (lebih bersih)
    Route::resource('barang', AdminBarangController::class);
    Route::resource('kategori', AdminKategoriController::class);
    Route::prefix('kelompok')->name('kelompok.')->group(function () {
        Route::resource('kategori', AdminKelompokKategoriController::class);
    });
    Route::resource('pelanggan', AdminPelangganController::class);
    Route::prefix('kelompok')->name('kelompok.')->group(function () {
        Route::resource('pelanggan', AdminKelompokPelangganController::class);
    });
    Route::resource('supplier', AdminSupplierController::class);
    Route::resource('user', AdminUserController::class);
    Route::get('/transaksi/pembelian', [AdminTransaksiPembelianController::class, 'index'])
        ->name('transaksi.pembelian.index');

    // CRUD Laporan Pembelian
    Route::get('transaksi/pembelian', [AdminTransaksiPembelianController::class, 'index'])->name('transaksi.pembelian.index');
    // Route::get('transaksi/pembelian/create', [AdminTransaksiPembelianController::class, 'create'])->name('transaksi.pembelian.create');
    Route::post('transaksi/pembelian', [AdminTransaksiPembelianController::class, 'store'])->name('transaksi.pembelian.store');
    Route::get('transaksi/pembelian/{id}/edit', [AdminTransaksiPembelianController::class, 'edit'])->name('transaksi.pembelian.edit');
    Route::put('transaksi/pembelian/{id}', [AdminTransaksiPembelianController::class, 'update'])->name('transaksi.pembelian.update');
    Route::delete('transaksi/pembelian/{id}', [AdminTransaksiPembelianController::class, 'destroy'])->name('transaksi.pembelian.destroy');



    // Laporan
    Route::get('laporan/pembelian', [AdminLaporanPembelianController::class, 'index'])->name('laporan.pembelian');

    Route::get('laporan/pembelian/cetak', [AdminLaporanPembelianController::class, 'cetak'])->name('laporan.pembelian.cetak');

    Route::get('laporan/stok', [AdminLaporanStokController::class, 'stok'])->name('laporan.stok');
    Route::get('laporan/stok/excel', [AdminLaporanStokController::class, 'exportExcel'])->name('laporan.stok.excel');
    Route::get('laporan/stok/pdf', [AdminLaporanStokController::class, 'exportPdf'])->name('laporan.stok.pdf');

    // Menu Kasir yang diakses Admin
    Route::get('laporan/produk', [KasirLaporanProdukController::class, 'laporanProduk'])->name('laporan.produk');
    Route::get('rekap/harian', [KasirRekapHarianController::class, 'rekapHarian'])->name('rekap.harian');
});

// ====================== KASIR ======================
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {

    Route::get('/', [KasirDashboardController::class, 'index'])->name('dashboard');

    Route::get('/transaksi', [KasirTransaksiController::class, 'index'])->name('transaksi');
    Route::post('/simpan/transaksi', [KasirTransaksiController::class, 'simpanTransaksi'])->name('simpan.transaksi');

    // QRIS
    Route::post('/qris/generate', [KasirQrisController::class, 'generate']);
    Route::post('/qris/callback', [KasirQrisController::class, 'callback'])->name('qris.callback');

    // Laporan & Cetak
    Route::get('/penjualan', [KasirLaporanPenjualanController::class, 'index'])->name('penjualan');
    Route::get('/penjualan/cetak', [KasirLaporanPenjualanController::class, 'cetak'])->name('penjualan.cetak');

    Route::get('/cetak.struk', [KasirCetakStrukController::class, 'index'])->name('cetak.struk');
    Route::get('/cetak.struk/{id}', [KasirCetakStrukController::class, 'struk']);

    Route::get('/laporan/produk', [KasirLaporanProdukController::class, 'laporanProduk'])->name('laporan.produk');
    Route::get('/laporan/produk/export', [KasirLaporanProdukController::class, 'export'])->name('laporan.produk.export');

    Route::get('/laporan/kasir', [KasirLaporanKasirController::class, 'laporanKasir'])->name('laporan.kasir');
    Route::get('/rekap/harian', [KasirRekapHarianController::class, 'rekapHarian'])->name('rekap.harian');
});

require __DIR__ . '/auth.php';
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');

            $table->foreignId('id_sekolah')
                  ->constrained('tb_sekolah', 'id_sekolah')
                  ->cascadeOnDelete();

            $table->foreignId('id_user')
                  ->constrained('tb_user', 'id_user')
                  ->restrictOnDelete();

            $table->foreignId('id_pelanggan')
                  ->nullable()
                  ->constrained('tb_pelanggan', 'id_pelanggan')
                  ->nullOnDelete();

            $table->dateTime('tanggal_penjualan')->useCurrent();

            $table->decimal('total_faktur', 14, 2);
            $table->decimal('total_bayar', 14, 2);
            $table->decimal('kembalian', 14, 2)->default(0);

            $table->enum('status_pembayaran', ['sudah bayar', 'belum bayar'])
                  ->default('belum bayar');

            $table->enum('jenis_transaksi', ['tunai', 'kredit'])
                  ->nullable();

            $table->string('cara_bayar', 50)->nullable()
                  ->comment('Cash, Transfer, QRIS, dll...');

            $table->text('note')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->boolean('is_delete')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_penjualan');
    }
};
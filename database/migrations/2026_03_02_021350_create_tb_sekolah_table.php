<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_sekolah', function (Blueprint $table) {
            $table->id('id_sekolah');
            $table->string('kode_sekolah', 20)->unique();
            $table->string('nama_sekolah', 150);
            $table->text('alamat_sekolah')->nullable();
            $table->string('website', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            
            // Jika ingin tetap ada updated_at (opsional)
            // $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_sekolah');
    }
};
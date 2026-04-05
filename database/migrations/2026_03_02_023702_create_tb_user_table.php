<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');

            $table->foreignId('id_sekolah')
                ->nullable() // ini bikin boleh NULL
                ->constrained('tb_sekolah', 'id_sekolah')
                ->nullOnDelete(); // alternatif kalau parent dihapus

            $table->foreignId('id_role')
                ->constrained('roles', 'id_role')
                ->restrictOnDelete();

            $table->string('username', 50);
            $table->string('password', 255);
            $table->string('nama_lengkap', 100);

            $table->boolean('is_active')->default(true);

            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->unique(['username', 'id_sekolah'], 'username_per_sekolah');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
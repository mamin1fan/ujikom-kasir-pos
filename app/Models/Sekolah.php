<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sekolah extends Model
{
    protected $table = 'tb_sekolah';
    protected $primaryKey = 'id_sekolah';

    // Hanya ada created_at tanpa updated_at
    public $timestamps = false;

    protected $fillable = [
        'kode_sekolah',
        'nama_sekolah',
        'alamat_sekolah',
        'website',
        'is_active',
        'created_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Sekolah punya banyak user
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_sekolah', 'id_sekolah');
    }

    /**
     * Sekolah punya banyak supplier
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'id_sekolah', 'id_sekolah');
    }

    /**
     * Sekolah punya banyak pelanggan
     */
    public function pelanggan(): HasMany
    {
        return $this->hasMany(Pelanggan::class, 'id_sekolah', 'id_sekolah');
    }

    /**
     * Sekolah punya banyak pembelian
     */
    public function pembelian(): HasMany
    {
        return $this->hasMany(Pembelian::class, 'id_sekolah', 'id_sekolah');
    }

    /**
     * Sekolah punya banyak penjualan
     */
    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'id_sekolah', 'id_sekolah');
    }
}
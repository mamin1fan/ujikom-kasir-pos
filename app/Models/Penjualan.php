<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'tb_penjualan';
    protected $primaryKey = 'id_penjualan';
    public $timestamps = false;

    protected $fillable = [
        'id_sekolah',
        'id_user',
        'id_pelanggan',
        'tanggal_penjualan',
        'total_faktur',
        'total_bayar',
        'kembalian',
        'status_pembayaran',
        'jenis_transaksi',
        'cara_bayar',
        'note',
        'created_by',
        'deleted_by',
        'is_delete',
    ];

    // Relasi
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }
}
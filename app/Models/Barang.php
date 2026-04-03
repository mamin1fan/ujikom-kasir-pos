<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    // public $timestamps = false;

    protected $fillable = [
        'id_sekolah',
        'barcode',
        'nama',
        'id_kategori',
        'id_kelompok_kategori',
        'id_supplier',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_delete',
    ];

    protected static function booted()
    {
        static::addGlobalScope('sekolah', function ($query) {
            if (auth()->check()) {
                $query->where('id_sekolah', auth()->user()->id_sekolah);
            }
        });
    }

    // Relasi
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function kelompokKategori()
    {
        return $this->belongsTo(KelompokKategori::class, 'id_kelompok_kategori', 'id_kelompok');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    // 🔗 Relasi ke DetailPenjualan
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_barang', 'id_barang');
    }
}



// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Barang extends Model
// {
//     protected static function booted()
//     {
//         static::addGlobalScope('sekolah', function ($query) {
//             $query->where('id_sekolah', session('sekolah_id'));
//         });
//     }
// };



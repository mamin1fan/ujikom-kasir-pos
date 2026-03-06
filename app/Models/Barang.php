<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;

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



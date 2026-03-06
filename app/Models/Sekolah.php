<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'tb_sekolah';
    protected $primaryKey = 'id_sekolah';

    public $timestamps = false; 
    // karena hanya ada created_at tanpa updated_at

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
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'id_sekolah', 'id_sekolah');
    }
}
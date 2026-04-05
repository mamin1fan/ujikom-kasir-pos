<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Supplier extends Model
{
    use SoftDeletes;
    protected $table = 'tb_supplier';
    protected $primaryKey = 'id_supplier';

    public $timestamps = false;

    // karena hanya ada created_at manual

    protected $fillable = [
        'id_sekolah',
        'nama',
        'no_telepon',
        'alamat_supplier',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'is_delete',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

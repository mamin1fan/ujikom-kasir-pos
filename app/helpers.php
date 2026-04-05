<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('sekolah_id')) {
    function sekolah_id()
    {
        return session('id_sekolah')
            ?? auth()->user()?->id_sekolah
            ?? abort(403, 'Sekolah tidak ditemukan');
    }
}

if (!function_exists('sekolah')) {
    function sekolah()
    {
        return \App\Models\Sekolah::find(sekolah_id());
    }
}
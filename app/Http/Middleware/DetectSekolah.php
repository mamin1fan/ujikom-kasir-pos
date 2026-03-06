<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Sekolah;

class DetectSekolah
{
    public function handle($request, Closure $next)
    {
        $subdomain = explode('.', $request->getHost())[0];

        $sekolah = Sekolah::where('kode_sekolah', $subdomain)->first();

        if (!$sekolah) {
            abort(404, 'Sekolah tidak ditemukan');
        }

        session(['sekolah_id' => $sekolah->id_sekolah]);

        return $next($request);
    }
}
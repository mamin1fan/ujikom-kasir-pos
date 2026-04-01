<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QrisController extends Controller
{
    public function generate(Request $request)
    {
        try {
            $response = Http::withBasicAuth(
                config('services.xendit.key'),
                ''
            )->post('https://api.xendit.co/qr_codes', [
                        'external_id' => 'trx_' . time(),
                        'type' => 'DYNAMIC',
                        'callback_url' => env('APP_URL') . '/kasir/qris/callback',
                        'amount' => (int) $request->total,
                    ]);

            if (!$response->successful()) {
                return response()->json([
                    'error' => $response->body()
                ], 500);
            }

            $data = $response->json();

            return response()->json([
                'qr_string' => $data['qr_string'],
                'id' => $data['id']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
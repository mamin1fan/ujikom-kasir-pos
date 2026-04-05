<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Barang;
use App\Models\DetailPembelian;
use Illuminate\Support\Facades\DB;

class TransaksiPembelianController extends Controller
{
    // ===================== INDEX =====================
    public function index()
    {
        $idSekolah = session('id_sekolah');

        $supplier = Supplier::where('id_sekolah', $idSekolah)->get();

        // Grouping barang per supplier
        $barangPerSupplier = [];
        $barang = Barang::where('id_sekolah', $idSekolah)->get();

        foreach ($supplier as $sup) {
            $barangPerSupplier[$sup->id_supplier] = $barang->where('id_supplier', $sup->id_supplier); // sesuaikan jika relasi beda
            // atau jika tidak ada relasi id_supplier di barang:
            // $barangPerSupplier[$sup->id] = $barang; // tampilkan semua barang
        }

        return view('role.admin.transaksi_pembelian', compact('supplier', 'barangPerSupplier'));
    }

    // ===================== STORE =====================
    public function store(Request $request)
    {
        // 1. Debug semua data yang masuk
        \Log::info('=== DEBUG STORE PEMBELIAN ===');
        \Log::info('Input Supplier: ' . $request->id_supplier);
        \Log::info('Tanggal Faktur: ' . $request->tanggal_faktur);
        \Log::info('Details Count: ' . count($request->details ?? []));
        \Log::info('Details Data: ', $request->details ?? []);

        // 2. Validasi
        $request->validate([
            'tanggal_faktur' => 'required|date',
            'id_supplier' => 'required|exists:tb_supplier,id_supplier',
            'details' => 'required|array|min:1',
            'details.*.id_barang' => 'required|integer|exists:tb_barang,id_barang',
            'details.*.satuan' => 'required|string|max:255',
            'details.*.jumlah' => 'required|integer|min:1',
            'details.*.harga_beli' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $idSekolah = auth()->user()->id_sekolah ?? sekolah_id();

            // Hitung total bayar
            $totalBayar = 0;
            foreach ($request->details as $detail) {
                if (!empty($detail['jumlah']) && $detail['jumlah'] > 0) {
                    $totalBayar += (int) $detail['jumlah'] * (float) ($detail['harga_beli'] ?? 0);
                }
            }

            // Buat Pembelian
            $pembelian = Pembelian::create([
                'id_sekolah' => $idSekolah,
                'id_supplier' => $request->id_supplier,
                'id_user' => Auth::id(),
                'nomor_faktur' => 'PB-' . date('YmdHis') . strtoupper(Str::random(4)),
                'tanggal_faktur' => $request->tanggal_faktur,
                'total_bayar' => $totalBayar,
                'status_pembelian' => 'selesai',
                'jenis_transaksi' => 'tunai',
                'cara_bayar' => 'Cash',
                'note' => $request->note ?? '-',
                'created_by' => Auth::id(),
                'is_delete' => 0,
            ]);

            $inserted = 0;

            foreach ($request->details as $detail) {
                if (empty($detail['jumlah']) || $detail['jumlah'] <= 0)
                    continue;

                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_barang' => $detail['id_barang'],
                    'satuan' => $detail['satuan'] ?? null,
                    'jumlah' => $detail['jumlah'],
                    'harga_beli' => $detail['harga_beli'] ?? 0,
                    'subtotal' => $detail['jumlah'] * ($detail['harga_beli'] ?? 0),
                ]);

                // Tambah stok
                Barang::where('id_barang', $detail['id_barang'])
                    ->increment('stok', $detail['jumlah']);

                $inserted++;
            }

            DB::commit();

            \Log::info("SUKSES - Pembelian ID {$pembelian->id_pembelian} berhasil disimpan dengan {$inserted} detail");

            return redirect()
                ->route('admin.transaksi.pembelian.index')
                ->with('success', "Pembelian berhasil disimpan ({$inserted} barang)");

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('ERROR Store Pembelian: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan transaksi. Error: ' . $e->getMessage());
        }
    }

    // ===================== UPDATE =====================
    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::where('id_pembelian', $id)
            ->where('is_delete', 0)
            ->firstOrFail();

        $request->validate([
            'tanggal_faktur' => 'required|date',
            'id_supplier' => 'required',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        $pembelian->update([
            'tanggal_faktur' => $request->tanggal_faktur,
            'id_supplier' => $request->id_supplier,
            'total_bayar' => $request->total_bayar,
            'note' => $request->note ?? null,
        ]);

        return redirect()
            ->route('admin.transaksi.pembelian.index')
            ->with('success', 'Pembelian berhasil diupdate');
    }

    // ===================== DESTROY (SOFT DELETE) =====================
    public function destroy($id)
    {
        $pembelian = Pembelian::where('id_pembelian', $id)
            ->where('is_delete', 0)
            ->firstOrFail();

        $pembelian->update([
            'is_delete' => 1,
            'deleted_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
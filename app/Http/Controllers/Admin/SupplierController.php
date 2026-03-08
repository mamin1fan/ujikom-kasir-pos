<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $suppliers = Supplier::with(['creator'])
            ->where('is_delete', 0)
            ->where('id_sekolah', $user->id_sekolah)
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            })
            ->paginate(10);

        $total_supplier = Supplier::where('is_delete', 0)
            ->where('id_sekolah', $user->id_sekolah)
            ->count();

        return view('role.admin.supplier', compact('suppliers', 'total_supplier'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
            'alamat_supplier' => 'nullable|string|max:255',
        ]);

        Supplier::create([
            'id_sekolah' => $user->id_sekolah,
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'alamat_supplier' => $request->alamat_supplier,
            'created_at' => now(),
            'created_by' => $user->id,
            'is_delete' => 0,
        ]);

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
            'alamat_supplier' => 'nullable|string|max:255',
        ]);

        $supplier = Supplier::where('id_supplier', $id)
            ->where('id_sekolah', $user->id_sekolah)
            ->firstOrFail();

        $supplier->update([
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'alamat_supplier' => $request->alamat_supplier,
        ]);

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil diupdate');
    }


    public function destroy($id)
    {
        $user = Auth::user();

        $supplier = Supplier::where('id_supplier', $id)
            ->where('id_sekolah', $user->id_sekolah)
            ->firstOrFail();

        $supplier->update([
            'is_delete' => 1,
            'deleted_at' => now(),
            'deleted_by' => $user->id,
        ]);

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil dihapus');
    }
}
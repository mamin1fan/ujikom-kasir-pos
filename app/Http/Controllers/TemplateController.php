<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller

{
    public function index(Request $request)
    {
        return view('role.admin.kategori', compact('kategori', 'kelompok_kategori', 'total_kategori'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.kategori.index')->with('success', 'Data berhasil ditambahkan');
    }

    // show form for editing an existing kategori

    public function update(Request $request, $id)
    {

        return redirect()->route('admin.kategori.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {

        return redirect()->route('admin.kategori.index')->with('success', 'Data berhasil dihapus');
    }

}

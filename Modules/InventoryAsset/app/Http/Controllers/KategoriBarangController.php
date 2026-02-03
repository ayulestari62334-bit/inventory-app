<?php

namespace Modules\AssetInventory\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AssetInventory\app\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    public function index(Request $request)
    {
        // JIKA ADA SEARCH
        if ($request->filled('q')) {
            $kategori = KategoriBarang::where('kode_barang', 'like', '%' . $request->q . '%')
                ->orWhere('nama_kategori', 'like', '%' . $request->q . '%')
                ->get();
        } else {
            // TAMPILKAN SEMUA DATA
            $kategori = KategoriBarang::all();
        }

        return view('assetinventory::kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'   => 'required|unique:kategori_barang,kode_barang',
            'nama_kategori' => 'required|unique:kategori_barang,nama_kategori',
            'keterangan'    => 'nullable',
        ]);

        KategoriBarang::create([
            'kode_barang'   => $request->kode_barang,
            'nama_kategori' => $request->nama_kategori,
            'keterangan'    => $request->keterangan,
        ]);

        // ⬅️ INI PENTING: balik ke index TANPA query
        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriBarang::findOrFail($id);

        $request->validate([
            'kode_barang'   => 'required|unique:kategori_barang,kode_barang,' . $kategori->id,
            'nama_kategori' => 'required|unique:kategori_barang,nama_kategori,' . $kategori->id,
            'keterangan'    => 'nullable',
        ]);

        $kategori->update([
            'kode_barang'   => $request->kode_barang,
            'nama_kategori' => $request->nama_kategori,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        KategoriBarang::findOrFail($id)->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}

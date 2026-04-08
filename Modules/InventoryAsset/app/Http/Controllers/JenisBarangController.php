<?php

namespace Modules\InventoryAsset\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\InventoryAsset\app\Models\JenisBarang;

class JenisBarangController extends Controller
{
    /**
     * Display a listing of the resource + SEARCH
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $jenisBarang = JenisBarang::when($search, function ($query, $search) {
                $query->where('kode_jenis', 'like', '%' . $search . '%')
                      ->orWhere('nama_jenis', 'like', '%' . $search . '%')
                      ->orWhere('keterangan', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('inventoryasset::jenisbarang.index', compact('jenisBarang', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_jenis' => 'required|max:10|unique:jenis_barang,kode_jenis',
            'nama_jenis' => 'required|max:100',
            'keterangan' => 'nullable',
        ]);

        JenisBarang::create([
            'kode_jenis' => $request->kode_jenis,
            'nama_jenis' => $request->nama_jenis,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Jenis barang berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        $request->validate([
            'kode_jenis' => 'required|max:10|unique:jenis_barang,kode_jenis,' . $id,
            'nama_jenis' => 'required|max:100',
            'keterangan' => 'nullable',
        ]);

        $jenisBarang->update([
            'kode_jenis' => $request->kode_jenis,
            'nama_jenis' => $request->nama_jenis,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Jenis barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        JenisBarang::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Jenis barang berhasil dihapus');
    }
}
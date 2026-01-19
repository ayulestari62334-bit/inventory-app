<?php

namespace Modules\InventoryAsset\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\InventoryAsset\app\Models\Merk;

class MerkController extends Controller
{
    /**
     * Menampilkan data merk + fitur cari
     */
    public function index(Request $request)
    {
        $cari = $request->cari;

        $merks = Merk::when($cari, function ($query) use ($cari) {
                        $query->where('kode_merk', 'like', "%{$cari}%")
                              ->orWhere('nama_merk', 'like', "%{$cari}%")
                              ->orWhere('keterangan', 'like', "%{$cari}%");
                    })
                    ->orderBy('id', 'desc')
                    ->paginate(10);

        return view('inventoryasset::merk.index', compact('merks', 'cari'));
    }

    /**
     * Simpan data merk
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_merk' => 'required|unique:merk_barang,kode_merk',
            'nama_merk' => 'required',
        ]);

        Merk::create([
            'kode_merk' => $request->kode_merk,
            'nama_merk' => $request->nama_merk,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('merk.index')
            ->with('success', 'Data merk berhasil ditambahkan');
    }

    /**
     * Update data merk
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_merk' => 'required|unique:merk_barang,kode_merk,' . $id,
            'nama_merk' => 'required',
        ]);

        $merk = Merk::findOrFail($id);

        $merk->update([
            'kode_merk' => $request->kode_merk,
            'nama_merk' => $request->nama_merk,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('merk.index')
            ->with('success', 'Data merk berhasil diperbarui');
    }

    /**
     * Hapus data merk
     */
    public function destroy($id)
    {
        Merk::findOrFail($id)->delete();

        return redirect()
            ->route('merk.index')
            ->with('success', 'Data merk berhasil dihapus');
    }
}

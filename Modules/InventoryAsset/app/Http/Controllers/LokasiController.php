<?php

namespace Modules\InventoryAsset\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\InventoryAsset\app\Models\Lokasi;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasi = Lokasi::paginate(10);
        return view('inventoryasset::lokasi.index', compact('lokasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Lokasi::create([
            'kode_lokasi' => $request->kode_lokasi,
            'nama_lokasi' => $request->nama_lokasi,
            'tipe_lokasi' => $request->tipe_lokasi,
            'keterangan'  => $request->keterangan,
        ]);

        return redirect()->route('lokasi.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $lokasi->update([
            'kode_lokasi' => $request->kode_lokasi,
            'nama_lokasi' => $request->nama_lokasi,
            'tipe_lokasi' => $request->tipe_lokasi,
            'keterangan'  => $request->keterangan,
        ]);

        return redirect()->route('lokasi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Lokasi::findOrFail($id)->delete();
        return redirect()->route('lokasi.index');
    }
}

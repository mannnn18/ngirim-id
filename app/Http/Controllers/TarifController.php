<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $data_tarif = Tarif::all();
        return view('tarif.index', compact('data_tarif'));
    }

    public function create()
    {
        // Ambil semua data cabang dari database
        $data_cabang = \App\Models\Cabang::all(); 
        
        // Kirim data cabang ke tampilan form tambah tarif
        return view('tarif.create', compact('data_cabang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kota_asal' => 'required',
            'kota_tujuan' => 'required',
            'harga_per_kg' => 'required|numeric',
            'estimasi_hari' => 'required|integer'
        ]);

        Tarif::create($request->all());
        return redirect('/tarif')->with('success', 'Data tarif baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $tarif = Tarif::findOrFail($id);
        return view('tarif.edit', compact('tarif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kota_asal' => 'required',
            'kota_tujuan' => 'required',
            'harga_per_kg' => 'required|numeric',
            'estimasi_hari' => 'required|integer'
        ]);

        $tarif = Tarif::findOrFail($id);
        $tarif->update($request->all());

        return redirect('/tarif')->with('success', 'Data tarif berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tarif = Tarif::findOrFail($id);
        $tarif->delete();

        return redirect('/tarif')->with('success', 'Data tarif berhasil dihapus!');
    }

    
}
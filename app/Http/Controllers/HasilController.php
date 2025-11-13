<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Partisipan;
use App\Models\SubLomba;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $hasil = Hasil::with(['partisipan', 'sublomba'])->get();
        return view('hasil.index', compact('hasil'));
    }

    public function create()
    {
        $partisipans = Partisipan::all();
        $sublombas = SubLomba::all();
        return view('hasil.create', compact('partisipans', 'sublombas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sublomba_id' => 'required|exists:sub_lomba,sublomba_id',
            'partisipan_id' => 'required|exists:partisipan,partisipan_id',
            'rank' => 'required|integer',
            'deskripsi' => 'nullable|string'
        ]);

        Hasil::create($request->all());
        return redirect()->route('hasil.index')->with('success', 'Data hasil berhasil ditambahkan');
    }

    public function destroy(Hasil $hasil)
    {
        $hasil->delete();
        return redirect()->route('hasil.index')->with('success', 'Data hasil berhasil dihapus');
    }
}

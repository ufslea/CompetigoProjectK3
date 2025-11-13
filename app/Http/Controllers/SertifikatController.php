<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Partisipan;
use App\Models\SubLomba;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function index()
    {
        $sertifikat = Sertifikat::with(['partisipan', 'sublomba'])->get();
        return view('sertifikat.index', compact('sertifikat'));
    }

    public function create()
    {
        $partisipans = Partisipan::all();
        $sublombas = SubLomba::all();
        return view('sertifikat.create', compact('partisipans', 'sublombas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'partisipan_id' => 'required|exists:partisipan,partisipan_id',
            'sublomba_id' => 'required|exists:sub_lomba,sublomba_id',
            'gambar' => 'required|string'
        ]);

        Sertifikat::create($request->all());
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan');
    }

    public function destroy(Sertifikat $sertifikat)
    {
        $sertifikat->delete();
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus');
    }
}

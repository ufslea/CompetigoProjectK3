<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Partisipan;
use App\Models\SubLomba;
use App\Models\Event;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $hasil = Hasil::with(['partisipan', 'sublomba'])->get();
        
        if (request()->routeIs('organizer.results.*')) {
            return view('organizer.results.index', compact('hasil'));
        } elseif (request()->routeIs('admin.results.*')) {
            return view('admin.results.index', compact('hasil'));
        } elseif (request()->routeIs('participant.results.*')) {
            return view('participant.results.index', compact('hasil'));
        }
        
        return view('hasil.index', compact('hasil'));
    }

    public function create()
    {
        $partisipans = Partisipan::all();
        $sublombas = SubLomba::all();
        
        if (request()->routeIs('organizer.results.*')) {
            return view('organizer.results.create', compact('partisipans', 'sublombas'));
        }
        
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
        
        if (request()->routeIs('organizer.results.*')) {
            return redirect()->route('organizer.results.index')->with('success', 'Data hasil berhasil ditambahkan');
        }
        
        return redirect()->route('hasil.index')->with('success', 'Data hasil berhasil ditambahkan');
    }

    public function destroy(Hasil $hasil)
    {
        $hasil->delete();
        return redirect()->route('hasil.index')->with('success', 'Data hasil berhasil dihapus');
    }

    public function show($competition)
    {
        $event = Event::findOrFail($competition);
        $hasil = Hasil::with(['partisipan', 'sublomba'])
            ->whereHas('sublomba', function($query) use ($event) {
                $query->where('event_id', $event->events_id);
            })
            ->get();
        return view('participant.results.index', compact('hasil', 'event'));
    }

    public function edit($id)
    {
        $hasil = Hasil::with(['partisipan', 'sublomba'])->findOrFail($id);
        $partisipans = Partisipan::all();
        $sublombas = SubLomba::all();
        
        if (request()->routeIs('admin.results.*')) {
            return view('admin.results.edit', compact('hasil', 'partisipans', 'sublombas'));
        } elseif (request()->routeIs('organizer.results.*')) {
            return view('organizer.results.edit', compact('hasil', 'partisipans', 'sublombas'));
        }
        
        return view('hasil.edit', compact('hasil', 'partisipans', 'sublombas'));
    }

    public function update(Request $request, $id)
    {
        $hasil = Hasil::findOrFail($id);
        
        $request->validate([
            'rank' => 'required|integer',
            'deskripsi' => 'nullable|string'
        ]);

        $hasil->update($request->all());
        
        if (request()->routeIs('admin.results.*')) {
            return redirect()->route('admin.results.index')->with('success', 'Data hasil berhasil diperbarui');
        } elseif (request()->routeIs('organizer.results.*')) {
            return redirect()->route('organizer.results.index')->with('success', 'Data hasil berhasil diperbarui');
        }
        
        return redirect()->route('hasil.index')->with('success', 'Data hasil berhasil diperbarui');
    }

    public function previewCertificate($certificate)
    {
        $sertifikat = \App\Models\Sertifikat::with(['partisipan', 'sublomba'])->findOrFail($certificate);
        return view('participant.results.certificates', compact('sertifikat'));
    }
}

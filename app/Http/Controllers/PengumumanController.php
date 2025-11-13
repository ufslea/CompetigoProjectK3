<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Event;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::with('event')->get();
        return view('pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        $events = Event::all();
        return view('pengumuman.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'events_id' => 'required|exists:events,events_id',
            'judul' => 'required|string',
            'isi' => 'required|string',
        ]);

        Pengumuman::create($request->all());
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit(Pengumuman $pengumuman)
    {
        $events = Event::all();
        return view('pengumuman.edit', compact('pengumuman', 'events'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $pengumuman->update($request->all());
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
    }
}

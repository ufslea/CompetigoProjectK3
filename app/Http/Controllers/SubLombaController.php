<?php

namespace App\Http\Controllers;

use App\Models\SubLomba;
use App\Models\Event;
use Illuminate\Http\Request;

class SubLombaController extends Controller
{
    public function index()
    {
        $subLombas = SubLomba::with('event')->get();
        return view('sublomba.index', compact('subLombas'));
    }

    public function create()
    {
        $events = Event::all();
        return view('sublomba.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,events_id',
            'nama' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
            'link' => 'nullable|string',
            'deadline' => 'required|date',
            'gambar' => 'nullable|string',
            'status' => 'required|string'
        ]);

        SubLomba::create($request->all());
        return redirect()->route('sublomba.index')->with('success', 'Sub Lomba berhasil ditambahkan');
    }

    public function edit(SubLomba $sublomba)
    {
        $events = Event::all();
        return view('sublomba.edit', compact('sublomba', 'events'));
    }

    public function update(Request $request, SubLomba $sublomba)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'deadline' => 'required|date',
        ]);

        $sublomba->update($request->all());
        return redirect()->route('sublomba.index')->with('success', 'Sub Lomba berhasil diperbarui');
    }

    public function destroy(SubLomba $sublomba)
    {
        $sublomba->delete();
        return redirect()->route('sublomba.index')->with('success', 'Sub Lomba berhasil dihapus');
    }
}

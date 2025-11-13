<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() {
        $events = Event::with('organizer')->latest()->get();
        return view('events.index', compact('events'));
    }

    public function create() {
        return view('events.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date',
        ]);

        Event::create($request->all());
        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat');
    }

    public function edit($id) {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, $id) {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return redirect()->route('events.index')->with('success', 'Event berhasil diupdate');
    }

    public function destroy($id) {
        Event::findOrFail($id)->delete();
        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus');
    }
}

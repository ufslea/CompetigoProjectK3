<?php

namespace App\Http\Controllers;

use App\Models\SubLomba;
use App\Models\Event;
use Illuminate\Http\Request;

class SubLombaController extends Controller
{
    public function index($event_id = null)
    {
        if ($event_id) {
            $event = \App\Models\Event::findOrFail($event_id);
            $subLombas = SubLomba::where('event_id', $event_id)->with('event')->get();
            
            if (request()->routeIs('organizer.sublomba.*')) {
                return view('organizer.events.sublomba.index', compact('subLombas', 'event'));
            } elseif (request()->routeIs('admin.events.sublomba.*')) {
                return view('admin.events.sublomba.index', compact('subLombas', 'event'));
            }
        }
        
        $subLombas = SubLomba::with('event')->get();
        return view('sublomba.index', compact('subLombas'));
    }

    public function create($event_id = null)
    {
        if ($event_id) {
            $event = Event::findOrFail($event_id);
            if (request()->routeIs('organizer.sublomba.*')) {
                return view('organizer.events.sublomba.create', compact('event'));
            }
        }
        
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
            'status' => 'required|enum'
        ]);

        $subLomba = SubLomba::create($request->all());
        
        if (request()->routeIs('organizer.sublomba.*')) {
            return redirect()->route('organizer.sublomba.index', $request->event_id)->with('success', 'Sub Lomba berhasil ditambahkan');
        }
        return redirect()->route('sublomba.index')->with('success', 'Sub Lomba berhasil ditambahkan');
    }

    public function edit($id)
    {
        $sublomba = SubLomba::findOrFail($id);
        $events = Event::all();
        
        if (request()->routeIs('organizer.sublomba.*')) {
            return view('organizer.events.sublomba.edit', compact('sublomba', 'events'));
        } elseif (request()->routeIs('admin.events.sublomba.*')) {
            return view('admin.events.sublomba.edit', compact('sublomba', 'events'));
        }
        
        return view('sublomba.edit', compact('sublomba', 'events'));
    }

    public function update(Request $request, $id)
    {
        $sublomba = SubLomba::findOrFail($id);
        
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'deadline' => 'required|date',
        ]);

        $sublomba->update($request->all());
        
        if (request()->routeIs('organizer.sublomba.*')) {
            return redirect()->route('organizer.sublomba.index', $sublomba->event_id)->with('success', 'Sub Lomba berhasil diperbarui');
        } elseif (request()->routeIs('admin.events.sublomba.*')) {
            return redirect()->route('admin.events.sublomba.index', ['event_id' => $sublomba->event_id])->with('success', 'Sub Lomba berhasil diperbarui');
        }
        return redirect()->route('sublomba.index')->with('success', 'Sub Lomba berhasil diperbarui');
    }

    public function destroy($id)
    {
        $sublomba = SubLomba::findOrFail($id);
        $event_id = $sublomba->event_id;
        $sublomba->delete();
        
        if (request()->routeIs('organizer.sublomba.*')) {
            return redirect()->route('organizer.sublomba.index', $event_id)->with('success', 'Sub Lomba berhasil dihapus');
        }
        return redirect()->route('sublomba.index')->with('success', 'Sub Lomba berhasil dihapus');
    }
}

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
            $event = Event::findOrFail($event_id);
            $subLombas = SubLomba::where('event_id', $event_id)->with('event')->get();
            
            if (request()->routeIs('organizer.events.sublomba.*')) {
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
        $event = Event::findOrFail($event_id);
        
        if (request()->routeIs('organizer.events.sublomba.*')) {
            return view('organizer.events.sublomba.create', compact('event'));
        } elseif (request()->routeIs('admin.events.sublomba.*')) {
            return view('admin.events.sublomba.create', compact('event'));
        }
        
        return view('sublomba.create', compact('event'));
    }

    public function store(Request $request, $event_id = null)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link' => 'nullable|url',
            'deadline' => 'required|date|after:today',
            'status' => 'required|in:open,closed',
        ]);

        $validated['event_id'] = $event_id;

        SubLomba::create($validated);
        
        if (request()->routeIs('organizer.events.sublomba.*')) {
            return redirect()->route('organizer.events.show', $event_id)->with('success', 'Sub Lomba berhasil ditambahkan');
        } elseif (request()->routeIs('admin.events.sublomba.*')) {
            return redirect()->route('admin.events.show', $event_id)->with('success', 'Sub Lomba berhasil ditambahkan');
        }
        
        return redirect()->route('events.show', $event_id)->with('success', 'Sub Lomba berhasil ditambahkan');
    }

    public function show($event_id, $id)
    {
        $subLomba = SubLomba::where('event_id', $event_id)->findOrFail($id);
        return view('sublomba.show', compact('subLomba'));
    }

    public function edit($event_id, $id)
    {
        $event = Event::findOrFail($event_id);
        $subLomba = SubLomba::where('event_id', $event_id)->findOrFail($id);
        
        if (request()->routeIs('organizer.events.sublomba.*')) {
            return view('organizer.events.sublomba.edit', compact('subLomba', 'event'));
        } elseif (request()->routeIs('admin.events.sublomba.*')) {
            return view('admin.events.sublomba.edit', compact('subLomba', 'event'));
        }
        
        return view('sublomba.edit', compact('subLomba', 'event'));
    }

    public function update(Request $request, $event_id, $id)
    {
        $subLomba = SubLomba::where('event_id', $event_id)->findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link' => 'nullable|url',
            'deadline' => 'required|date',
            'status' => 'required|in:open,closed',
        ]);

        $subLomba->update($validated);
        
        if (request()->routeIs('organizer.events.sublomba.*')) {
            return redirect()->route('organizer.events.show', $event_id)->with('success', 'Sub Lomba berhasil diperbarui');
        } elseif (request()->routeIs('admin.events.sublomba.*')) {
            return redirect()->route('admin.events.show', $event_id)->with('success', 'Sub Lomba berhasil diperbarui');
        }
        
        return redirect()->route('events.show', $event_id)->with('success', 'Sub Lomba berhasil diperbarui');
    }

    public function destroy($event_id, $id)
    {
        $subLomba = SubLomba::where('event_id', $event_id)->findOrFail($id);
        $subLomba->delete();
        
        if (request()->routeIs('organizer.events.sublomba.*')) {
            return redirect()->route('organizer.events.show', $event_id)->with('success', 'Sub Lomba berhasil dihapus');
        } elseif (request()->routeIs('admin.events.sublomba.*')) {
            return redirect()->route('admin.events.show', $event_id)->with('success', 'Sub Lomba berhasil dihapus');
        }
        
        return redirect()->route('events.show', $event_id)->with('success', 'Sub Lomba berhasil dihapus');
    }
}

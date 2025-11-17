<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Untuk participant view, tambah pagination
        if (request()->routeIs('participant.competitions.*')) {
            $events = Event::orderBy('tanggal_mulai', 'desc')
                ->paginate(12);
            
            return view('participant.competitions.index', compact('events'));
        }
        
        $events = Event::paginate(15);
        
        if (request()->routeIs('organizer.events.*')) {
            return view('organizer.events.index', compact('events'));
        } elseif (request()->routeIs('admin.events.*')) {
            return view('admin.events.index', compact('events'));
        }
        
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('organizer.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organizer_id' => 'required|integer|exists:users,user_id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'url' => 'required|url',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:draft,active,finished',
        ]);

        Event::create($validated);

        if (request()->routeIs('organizer.events.*')) {
            return redirect()->route('organizer.events.index')->with('success', 'Event berhasil dibuat.');
        }
        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function show($id)
    {
        $event = Event::with(['subLombas', 'pengumumans'])->findOrFail($id);
        
        if (request()->routeIs('organizer.events.show')) {
            return view('organizer.events.show', compact('event'));
        } elseif (request()->routeIs('admin.events.show')) {
            return view('admin.events.show', compact('event'));
        } elseif (request()->routeIs('participant.competitions.show')) {
            return view('participant.competitions.show', compact('event'));
        } elseif (request()->routeIs('competitions.show')) {
            return view('participant.competitions.show', compact('event'));
        }
        
        return view('events.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('organizer.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'organizer_id' => 'required|integer|exists:users,user_id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'url' => 'required|url',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:draft,active,finished',
        ]);

        $event->update($validated);

        if (request()->routeIs('organizer.events.*')) {
            return redirect()->route('organizer.events.index')->with('success', 'Event berhasil diperbarui.');
        }
        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        if (request()->routeIs('organizer.events.*')) {
            return redirect()->route('organizer.events.index')->with('success', 'Event berhasil dihapus.');
        }
        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus.');
    }
}


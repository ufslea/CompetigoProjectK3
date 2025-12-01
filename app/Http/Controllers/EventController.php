<?php

namespace App\Http\Controllers;

use App\Models\Event; // Assuming the model name is Event
use Illuminate\Http\Request;



class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        
        // Check route context to return appropriate view
        if (request()->routeIs('organizer.events.*')) {
            return view('organizer.events.index', compact('events'));
        } elseif (request()->routeIs('admin.events.*')) {
            return view('admin.events.index', compact('events'));
        } elseif (request()->routeIs('participant.competitions.*')) {
            return view('participant.competitions.index', compact('events'));
        }
        
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->routeIs('organizer.events.*')) {
            return view('organizer.events.create');
        }
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'organizer_id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'url' => 'required|url',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string',
        ]);

        Event::create($validated);

        if (request()->routeIs('organizer.events.*')) {
            return redirect()->route('organizer.events.index')->with('success', 'Event created successfully.');
        }
        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = Event::with('subLombas')->findOrFail($id);
        
        // Check route context to return appropriate view
        if (request()->routeIs('organizer.events.show')) {
            return view('organizer.events.show', compact('event'));
        } elseif (request()->routeIs('admin.events.show')) {
            return view('admin.events.show', compact('event'));
        } elseif (request()->routeIs('participant.competitions.show')) {
            return view('participant.competitions.show', compact('event'));
        }
        
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        if (request()->routeIs('organizer.events.*')) {
            return view('organizer.events.edit', compact('event'));
        }
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'organizer_id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'url' => 'required|url',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|string',
        ]);

        $event->update($validated);

        if (request()->routeIs('organizer.events.*')) {
            return redirect()->route('organizer.events.index')->with('success', 'Event updated successfully.');
        }
        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        if (request()->routeIs('organizer.events.*')) {
            return redirect()->route('organizer.events.index')->with('success', 'Event deleted successfully.');
        }
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}


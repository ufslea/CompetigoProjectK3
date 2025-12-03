<?php

namespace App\Http\Controllers;

use App\Models\Event; // Assuming the model name is Event
use Illuminate\Http\Request;



class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $status = $request->input('status');

    $events = Event::query()
        ->when($search, function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->paginate(10)
        ->withQueryString(); // penting agar filter tetap saat pindah halaman

    return view('organizer.events.index', [
        'events' => $events,
        'search' => $search,
        'status' => $status,
    ]);
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

    // VALIDASI
    $request->validate([
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'url' => 'nullable|string',
        'tanggal_mulai' => 'required|date',
        'tanggal_akhir' => 'required|date',
        'status' => 'required',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // UPLOAD GAMBAR BARU (JIKA ADA)
    if ($request->hasFile('gambar')) {

        // hapus file lama
        if ($event->gambar && file_exists(storage_path('app/public/' . $event->gambar))) {
            unlink(storage_path('app/public/' . $event->gambar));
        }

        // upload file baru
        $gambarBaru = $request->file('gambar')->store('events', 'public');
        $event->gambar = $gambarBaru;
    }

    // UPDATE FIELD LAINNYA
    $event->nama = $request->nama;
    $event->deskripsi = $request->deskripsi;
    $event->url = $request->url;
    $event->tanggal_mulai = $request->tanggal_mulai;
    $event->tanggal_akhir = $request->tanggal_akhir;
    $event->status = $request->status;

    $event->save();

    return redirect()->route('organizer.events.index')
        ->with('success', 'Event berhasil diperbarui');
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


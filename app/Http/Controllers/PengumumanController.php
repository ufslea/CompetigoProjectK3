<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Event;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $search = request()->query('search', '');
        $event_filter = request()->query('event', '');
        
        $query = Pengumuman::with('event');
        
        // Search by judul or isi
        if ($search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
        }
        
        // Filter by event
        if ($event_filter) {
            $query->where('events_id', $event_filter);
        }
        
        $pengumumans = $query->orderBy('created_at', 'desc')->paginate(15);
        $events = Event::all();
        
        if (request()->routeIs('organizer.announcements.*')) {
            return view('organizer.announcements.index', compact('pengumumans', 'search', 'event_filter', 'events'));
        } elseif (request()->routeIs('admin.announcements.*')) {
            return view('admin.announcements.index', compact('pengumumans', 'search', 'event_filter', 'events'));
        }
        
        return view('pengumuman.index', compact('pengumumans', 'search', 'event_filter', 'events'));
    }

    public function create()
    {
        $events = Event::all();
        
        if (request()->routeIs('organizer.announcements.*')) {
            return view('organizer.announcements.create', compact('events'));
        } elseif (request()->routeIs('admin.announcements.*')) {
            return view('admin.announcements.create', compact('events'));
        }
        
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
        
        if (request()->routeIs('organizer.announcements.*')) {
            return redirect()->route('organizer.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan');
        } elseif (request()->routeIs('admin.announcements.*')) {
            return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan');
        }
        
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $events = Event::all();
        
        if (request()->routeIs('organizer.announcements.*')) {
            return view('organizer.announcements.edit', compact('pengumuman', 'events'));
        } elseif (request()->routeIs('admin.announcements.*')) {
            return view('admin.announcements.edit', compact('pengumuman', 'events'));
        }
        
        return view('pengumuman.edit', compact('pengumuman', 'events'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update($request->all());
        
        if (request()->routeIs('organizer.announcements.*')) {
            return redirect()->route('organizer.announcements.index')->with('success', 'Pengumuman berhasil diperbarui');
        } elseif (request()->routeIs('admin.announcements.*')) {
            return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui');
        }
        
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();
        
        if (request()->routeIs('organizer.announcements.*')) {
            return redirect()->route('organizer.announcements.index')->with('success', 'Pengumuman berhasil dihapus');
        } elseif (request()->routeIs('admin.announcements.*')) {
            return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus');
        }
        
        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus');
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::with('event')->findOrFail($id);
        
        // Check route context to return appropriate view
        if (request()->routeIs('organizer.announcements.show')) {
            return view('organizer.announcements.show', compact('pengumuman'));
        } elseif (request()->routeIs('admin.announcements.show')) {
            return view('admin.announcements.show', compact('pengumuman'));
        }
        
        return view('pengumuman.show', compact('pengumuman'));
    }

    public function announcement($competition)
    {
        $event = Event::findOrFail($competition);
        $pengumumans = Pengumuman::where('events_id', $event->events_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('participant.competitions.announcements', compact('pengumumans', 'event'));
    }
}

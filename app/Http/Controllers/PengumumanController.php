<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Event;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? null;
        $status = $request->status ?? null;
        $event_filter = $request->event_filter ?? null;

        // Query pengumuman
        $pengumuman = Pengumuman::when($search, function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);

        // Events untuk dropdown
        $events = Event::orderBy('nama')->get();

        return view('organizer.announcements.index', [
    'pengumumans' => $pengumuman,
    'events' => $events,
    'search' => $search,
    'status' => $status,
    'event_filter' => $event_filter,
]);

    }

    public function create()
    {
        $events = Event::orderBy('nama')->get();

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
        $events = Event::orderBy('nama')->get();

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
            ->latest()
            ->get();

        return view('participant.competitions.announcements', compact('pengumumans', 'event'));
    }
}

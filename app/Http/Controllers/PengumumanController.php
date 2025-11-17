<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Event;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::with('event')->orderBy('created_at', 'desc')->paginate(15);
        
        if (request()->routeIs('organizer.announcements.*')) {
            return view('organizer.announcements.index', compact('pengumumans'));
        } elseif (request()->routeIs('admin.announcements.*')) {
            return view('admin.announcements.index', compact('pengumumans'));
        }
        
        return view('pengumuman.index', compact('pengumumans'));
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
        $validated = $request->validate([
            'events_id' => 'required|integer|exists:events,events_id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        try {
            Pengumuman::create($validated);
            
            if (request()->routeIs('organizer.announcements.*')) {
                return redirect()->route('organizer.announcements.index')
                    ->with('success', 'Pengumuman berhasil ditambahkan');
            } elseif (request()->routeIs('admin.announcements.*')) {
                return redirect()->route('admin.announcements.index')
                    ->with('success', 'Pengumuman berhasil ditambahkan');
            }
            
            return redirect()->route('pengumuman.index')
                ->with('success', 'Pengumuman berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan pengumuman: ' . $e->getMessage())->withInput();
        }
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
        
        $validated = $request->validate([
            'events_id' => 'required|integer|exists:events,events_id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        try {
            $pengumuman->update($validated);
            
            if (request()->routeIs('organizer.announcements.*')) {
                return redirect()->route('organizer.announcements.index')
                    ->with('success', 'Pengumuman berhasil diperbarui');
            } elseif (request()->routeIs('admin.announcements.*')) {
                return redirect()->route('admin.announcements.index')
                    ->with('success', 'Pengumuman berhasil diperbarui');
            }
            
            return redirect()->route('pengumuman.index')
                ->with('success', 'Pengumuman berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui pengumuman: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();
        
        if (request()->routeIs('organizer.announcements.*')) {
            return redirect()->route('organizer.announcements.index')
                ->with('success', 'Pengumuman berhasil dihapus');
        } elseif (request()->routeIs('admin.announcements.*')) {
            return redirect()->route('admin.announcements.index')
                ->with('success', 'Pengumuman berhasil dihapus');
        }
        
        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus');
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

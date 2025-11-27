<?php

namespace App\Http\Controllers;

use App\Models\Partisipan;
use App\Models\User;
use App\Models\SubLomba;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartisipanController extends Controller
{
    public function index($event_id = null)
    {
        if ($event_id) {
            $event = Event::findOrFail($event_id);
            $participants = Partisipan::with(['user', 'sublomba'])
                ->whereHas('sublomba', function($query) use ($event_id) {
                    $query->where('event_id', $event_id);
                })
                ->get();
            
            if (request()->routeIs('admin.events.participants.*')) {
                return view('admin.events.participants.index', compact('participants', 'event'));
            }
        }
        
        $participants = Partisipan::with(['user', 'sublomba.event'])->get();
        
        if (request()->routeIs('organizer.participants.*')) {
            return view('organizer.participants.index', compact('participants'));
        } elseif (request()->routeIs('admin.events.participants.*')) {
            return view('admin.events.participants.index', compact('participants', 'event_id'));
        }
        
        return view('partisipan.index', compact('participants'));
    }

    public function create($competition = null)
    {
        if ($competition) {
            $event = Event::findOrFail($competition);
            $sublomba = $event->subLombas;
            return view('participant.competitions.create', compact('event', 'sublomba'));
        }
        
        $events = Event::all();
        $sublombas = SubLomba::all();
        return view('partisipan.create', compact('events', 'sublombas'));
    }

    public function show($id)
    {
        $partisipan = Partisipan::with(['user', 'sublomba.event'])->findOrFail($id);
        
        if (request()->routeIs('organizer.participants.*')) {
            return view('organizer.participants.show', compact('partisipan'));
        } elseif (request()->routeIs('admin.events.participants.*')) {
            return view('admin.events.participants.show', compact('partisipan'));
        }
        
        return view('partisipan.show', compact('partisipan'));
    }

    public function edit($id)
    {
        $partisipan = Partisipan::with(['user', 'sublomba'])->findOrFail($id);
        $users = User::all();
        $sublombas = SubLomba::all();
        
        if (request()->routeIs('admin.events.participants.*')) {
            return view('admin.events.participants.edit', compact('partisipan', 'users', 'sublombas'));
        } elseif (request()->routeIs('participant.competitions.*')) {
            $event = $partisipan->sublomba->event;
            return view('participant.competitions.edit', compact('partisipan', 'users', 'sublombas', 'event'));
        }
        
        return view('partisipan.edit', compact('partisipan', 'users', 'sublombas'));
    }

    public function update(Request $request, $id)
    {
        $partisipan = Partisipan::findOrFail($id);
        
        // Untuk participant, bisa update institusi, kontak, dan file_karya
        if (request()->routeIs('participant.competitions.*')) {
            $validated = $request->validate([
                'institusi' => 'required|string',
                'kontak' => 'required|string',
                'file_karya' => 'nullable|string',
            ]);
            
            $partisipan->update($validated);
        } else {
            // Untuk admin/organizer, bisa update status
            $validated = $request->validate([
                'status' => 'required|in:pending,approved,rejected,submitted',
            ]);
            
            $partisipan->update($validated);
        }
        
        if (request()->routeIs('admin.events.participants.*')) {
            return redirect()->route('admin.events.participants.index', $partisipan->sublomba->event_id)->with('success', 'Peserta berhasil diperbarui');
        } elseif (request()->routeIs('participant.competitions.*')) {
            return redirect()->route('participant.competitions.show', $partisipan->sublomba->event_id)->with('success', 'Peserta berhasil diperbarui');
        } elseif (request()->routeIs('organizer.participants.*')) {
            return redirect()->route('organizer.participants.index')->with('success', 'Peserta berhasil diperbarui');
        }
        
        return redirect()->route('partisipan.index')->with('success', 'Peserta berhasil diperbarui');
    }

    public function destroy($id)
    {
        $partisipan = Partisipan::findOrFail($id);
        $event_id = $partisipan->sublomba->event_id;
        $partisipan->delete();
        
        if (request()->routeIs('admin.events.participants.*')) {
            return redirect()->route('admin.events.participants.index', $event_id)->with('success', 'Peserta berhasil dihapus');
        } elseif (request()->routeIs('participant.competitions.*')) {
            return redirect()->route('participant.competitions.index')->with('success', 'Peserta berhasil dihapus');
        }
        
        return redirect()->route('organizer.participants.index')->with('success', 'Peserta berhasil dihapus');
    }

    public function register($competition)
    {
        $event = Event::findOrFail($competition);
        return view('participant.competitions.register', compact('event'));
    }

    public function storeRegistration(Request $request, $competition)
    {
        $event = Event::findOrFail($competition);
        $sublomba = $event->subLombas()->first();
        
        if (!$sublomba) {
            return redirect()->back()->with('error', 'Tidak ada sub-lomba untuk event ini.');
        }

        $validated = $request->validate([
            'institusi' => 'required|string',
            'kontak' => 'required|string',
        ]);

        Partisipan::create([
            'user_id' => Auth::id(),
            'sublomba_id' => $sublomba->sublomba_id,
            'institusi' => $validated['institusi'],
            'kontak' => $validated['kontak'],
            'status' => 'pending',
            'registered_at' => now(),
        ]);

        return redirect()->route('participant.competitions.show', $competition)
            ->with('success', 'Registrasi berhasil!');
    }

    public function store(Request $request, $competition)
    {
        $event = Event::findOrFail($competition);
        
        $validated = $request->validate([
            'sublomba_id' => 'required|integer|exists:sub_lomba,sublomba_id',
            'institusi' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'file_karya' => 'nullable|string',
        ]);

        try {
            // Check jika user sudah submit untuk sub-lomba ini
            $existingSubmission = Partisipan::where('user_id', Auth::id())
                ->where('sublomba_id', $validated['sublomba_id'])
                ->first();

            if ($existingSubmission) {
                return back()->with('error', 'Anda sudah submit untuk sub-lomba ini. Gunakan edit untuk mengubah.');
            }

            $partisipan = Partisipan::create([
                'user_id' => Auth::id(),
                'sublomba_id' => $validated['sublomba_id'],
                'institusi' => $validated['institusi'],
                'kontak' => $validated['kontak'],
                'file_karya' => $validated['file_karya'],
                'status' => 'submitted',
            ]);

            return redirect()
                ->route('participant.competitions.show', $competition)
                ->with('success', 'Karya berhasil disubmit!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal submit karya: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function submit(Request $request, $competition)
    {
        $event = Event::findOrFail($competition);
        $sublomba = $event->subLombas()->first();
        
        if (!$sublomba) {
            return redirect()->back()->with('error', 'Tidak ada sub-lomba untuk event ini.');
        }

        $validated = $request->validate([
            'file_karya' => 'nullable|string|url',
        ]);

        $partisipan = Partisipan::where('user_id', Auth::id())
            ->where('sublomba_id', $sublomba->sublomba_id)
            ->firstOrFail();

        $partisipan->update([
            'file_karya' => $validated['file_karya'],
            'status' => 'submitted',
        ]);

        return redirect()->route('participant.competitions.show', $competition)
            ->with('success', 'Pengiriman berhasil!');
    }
}

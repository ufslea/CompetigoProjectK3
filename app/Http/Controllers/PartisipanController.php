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
            $partisipans = Partisipan::with(['user', 'sublomba'])
                ->whereHas('sublomba', function($query) use ($event_id) {
                    $query->where('event_id', $event_id);
                })
                ->get();
            
            if (request()->routeIs('admin.events.participants.*')) {
                return view('admin.events.participants.index', compact('partisipans', 'event_id'));
            }
        }
        
        $partisipans = Partisipan::with(['user', 'sublomba'])->get();
        
        if (request()->routeIs('organizer.participants.*')) {
            return view('organizer.participants.index', compact('partisipans'));
        } elseif (request()->routeIs('admin.events.participants.*')) {
            return view('admin.events.participants.index', compact('partisipans'));
        }
        
        return view('partisipan.index', compact('partisipans'));
    }

    public function create($competition = null)
    {
        if ($competition) {
            $event = Event::findOrFail($competition);
            $sublombas = $event->subLombas;
            return view('participant.competitions.create', compact('event', 'sublombas'));
        }
        
        $users = User::all();
        $sublombas = SubLomba::all();
        return view('partisipan.create', compact('users', 'sublombas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'sublomba_id' => 'required|exists:sub_lomba,sublomba_id',
            'institusi' => 'required',
            'kontak' => 'required',
            'file_karya' => 'nullable|string',
            'status' => 'required|enum'
        ]);

        Partisipan::create($request->all());
        return redirect()->route('partisipan.index')->with('success', 'Partisipan berhasil ditambahkan');
    }

    public function edit($id, $competition = null)
    {
        $partisipan = Partisipan::findOrFail($id);
        $users = User::all();
        $sublombas = SubLomba::all();
        
        if (request()->routeIs('admin.events.participants.*')) {
            return view('admin.events.participants.edit', compact('partisipan', 'users', 'sublombas'));
        } elseif (request()->routeIs('participant.competitions.*')) {
            $event = $competition ? Event::findOrFail($competition) : $partisipan->sublomba->event;
            return view('participant.competitions.edit', compact('partisipan', 'users', 'sublombas', 'event'));
        }
        
        return view('partisipan.edit', compact('partisipan', 'users', 'sublombas'));
    }

    public function update(Request $request, $id)
    {
        $partisipan = Partisipan::findOrFail($id);
        
        // Untuk participant, bisa update institusi, kontak, dan file_karya
        if (request()->routeIs('participant.competitions.*')) {
            $request->validate([
                'institusi' => 'required|string',
                'kontak' => 'required|string',
                'file_karya' => 'nullable|string',
            ]);
            
            $partisipan->update($request->only(['institusi', 'kontak', 'file_karya']));
        } else {
            // Untuk admin, hanya bisa update status
        $request->validate([
            'status' => 'required|string',
        ]);

            $partisipan->update($request->only(['status']));
        }
        
        if (request()->routeIs('admin.events.participants.*')) {
            return redirect()->route('admin.events.participants.index', $partisipan->sublomba->event_id)->with('success', 'Partisipan berhasil diperbarui');
        } elseif (request()->routeIs('participant.competitions.*')) {
            return redirect()->route('participant.competitions.show', $partisipan->sublomba->event_id)->with('success', 'Partisipan berhasil diperbarui');
        }
        
        return redirect()->route('partisipan.index')->with('success', 'Partisipan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $partisipan = Partisipan::findOrFail($id);
        $partisipan->delete();
        
        if (request()->routeIs('participant.competitions.*')) {
            return redirect()->route('participant.competitions.index')->with('success', 'Partisipan berhasil dihapus');
        }
        
        return redirect()->route('partisipan.index')->with('success', 'Partisipan berhasil dihapus');
    }

    public function show($id)
    {
        $partisipan = Partisipan::with(['user', 'sublomba'])->findOrFail($id);
        
        if (request()->routeIs('organizer.participants.*')) {
            return view('organizer.participants.show', compact('partisipan'));
        } elseif (request()->routeIs('admin.events.participants.*')) {
            return view('admin.events.participants.show', compact('partisipan'));
        }
        
        return view('partisipan.show', compact('partisipan'));
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
            return redirect()->back()->with('error', 'No sub-lomba found for this event.');
        }

        $request->validate([
            'institusi' => 'required|string',
            'kontak' => 'required|string',
        ]);

        Partisipan::create([
            'user_id' => Auth::id(),
            'sublomba_id' => $sublomba->sublomba_id,
            'institusi' => $request->institusi,
            'kontak' => $request->kontak,
            'status' => 'pending',
        ]);

        return redirect()->route('participant.competitions.show', $competition)
            ->with('success', 'Registration successful!');
    }

    public function submit(Request $request, $competition)
    {
        $event = Event::findOrFail($competition);
        $sublomba = $event->subLombas()->first();
        
        if (!$sublomba) {
            return redirect()->back()->with('error', 'No sub-lomba found for this event.');
        }

        $request->validate([
            'file_karya' => 'nullable|string',
        ]);

        $partisipan = Partisipan::where('user_id', Auth::id())
            ->where('sublomba_id', $sublomba->sublomba_id)
            ->firstOrFail();

        $partisipan->update([
            'file_karya' => $request->file_karya,
            'status' => 'submitted',
        ]);

        return redirect()->route('participant.competitions.show', $competition)
            ->with('success', 'Submission successful!');
    }
}

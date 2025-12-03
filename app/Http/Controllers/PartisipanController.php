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
public function index(Request $request, $event_id = null)
{
    $search = $request->input('search', '');
    $status = $request->input('status', ''); // filter status submission
    $verification = $request->input('verification', ''); // filter verification

    $query = Partisipan::with(['user', 'sublomba']);

    if ($event_id) {
        $query->whereHas('sublomba', fn($q) => $q->where('event_id', $event_id));
    }

    if ($search !== '') {
        $query->whereHas('user', fn($q) => 
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
        );
    }

    // Filter status submission
    if ($status !== '') {
        $query->where('status', $status);
    }

    // Filter verification
    if ($verification !== '') {
        $query->where('verification_status', $verification);
    }

    $partisipans = $query->orderBy('created_at', 'desc')
                         ->paginate(10)
                         ->withQueryString();

    return view('organizer.participants.index', [
        'participants' => $partisipans,
        'search' => $search,
        'status' => $status,
        'verification' => $verification,
    ]);
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
    
    public function verify(Request $request, $id)
{
    $partisipan = Partisipan::findOrFail($id);
    $partisipan->verification_status = 'approved';
    $partisipan->verification_notes = $request->verification_notes;
    $partisipan->verified_at = now();
    $partisipan->verified_by = auth()->id();
    $partisipan->save();

    return redirect()->back()->with('success', 'Peserta berhasil diverifikasi.');
}

public function reject(Request $request, $id)
{
    $request->validate([
        'verification_notes' => 'required|string'
    ]);

    $partisipan = Partisipan::findOrFail($id);
    $partisipan->verification_status = 'rejected';
    $partisipan->verification_notes = $request->verification_notes;
    $partisipan->verified_at = now();
    $partisipan->verified_by = auth()->id();
    $partisipan->save();

    return redirect()->back()->with('success', 'Peserta ditolak.');
}

}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // GET participant/reports atau admin/reports → daftar laporan
    public function index()
    {
        if (request()->routeIs('participant.reports.*')) {
            // Participant hanya lihat laporan mereka sendiri
            $laporans = Laporan::with(['pelapor', 'event'])
                ->where('pelapor_id', Auth::id())
                ->orderByDesc('created_at')
                ->paginate(15);
            return view('participant.reports.index', compact('laporans'));
        }
        
        // Admin lihat semua laporan
        $laporans = Laporan::with(['pelapor', 'event'])
            ->orderByDesc('created_at')
            ->paginate(15);
        return view('admin.reports.index', compact('laporans'));
    }

    // GET participant/reports/create → form create laporan
    public function create()
    {
        $events = Event::all();
        return view('participant.reports.create', compact('events'));
    }

    // POST participant/reports → simpan laporan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'events_id' => 'required|exists:events,events_id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bukti' => 'nullable|string',
        ]);

        $validated['pelapor_id'] = Auth::id();
        $validated['status'] = 'pending';

        Laporan::create($validated);

        return redirect()->route('participant.reports.index')
            ->with('success', 'Laporan berhasil dikirim.');
    }

    // GET participant/reports/{laporan}/edit → form edit laporan
    public function edit($laporan_id)
    {
        $laporan = Laporan::with(['pelapor', 'event'])->findOrFail($laporan_id);
        
        // Pastikan hanya pemilik yang bisa edit
        if (request()->routeIs('participant.reports.*') && $laporan->pelapor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        if (request()->routeIs('participant.reports.*')) {
            $events = Event::all();
            return view('participant.reports.edit', compact('laporan', 'events'));
        }
        
        // Admin edit
        return view('admin.reports.edit', compact('laporan'));
    }

    // PUT/PATCH participant/reports/{laporan} atau admin/reports/{laporan}
    public function update(Request $request, $laporan_id)
    {
        $laporan = Laporan::findOrFail($laporan_id);
        
        if (request()->routeIs('participant.reports.*')) {
            // Participant update laporan mereka sendiri
            if ($laporan->pelapor_id !== Auth::id()) {
                abort(403, 'Unauthorized');
            }
            
            $validated = $request->validate([
                'events_id' => 'required|exists:events,events_id',
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'bukti' => 'nullable|string',
            ]);
            
            $laporan->update($validated);
            
            return redirect()->route('participant.reports.index')
                ->with('success', 'Laporan berhasil diperbarui.');
        }
        
        // Admin update status dan tanggapan
        $validated = $request->validate([
            'status'     => 'required|in:pending,processed,finished,refused',
            'tanggapan'  => 'nullable|string|max:2000',
        ]);

        $laporan->update($validated);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    // DELETE participant/reports/{laporan}
    public function destroy($laporan_id)
    {
        $laporan = Laporan::findOrFail($laporan_id);
        
        // Hanya pemilik yang bisa delete
        if ($laporan->pelapor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $laporan->delete();
        
        return redirect()->route('participant.reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    // GET admin/reports/{laporan} → show detail
    public function show($laporan_id)
    {
        $laporan = Laporan::with(['pelapor', 'event'])->findOrFail($laporan_id);
        return view('admin.reports.show', compact('laporan'));
    }
}
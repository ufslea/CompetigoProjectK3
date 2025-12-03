<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Partisipan;
use App\Models\SubLomba;
use App\Models\Event;
use Illuminate\Http\Request;

class HasilController extends Controller
{
public function index(Request $request)
{
    $search = $request->search;
    $sublomba_filter = $request->sublomba;

    // Ambil semua sublomba untuk dropdown
    $sublombas = \App\Models\SubLomba::orderBy('nama')->get();

    // Query hasil + filter
    $hasil = \App\Models\Hasil::with(['partisipan.user', 'sublomba'])
        ->when($search, function($q) use ($search) {
            $q->whereHas('partisipan.user', function($u) use ($search) {
                $u->where('nama', 'like', "%$search%");
            })->orWhere('deskripsi', 'like', "%$search%");
        })
        ->when($sublomba_filter, function($q) use ($sublomba_filter) {
            $q->where('sublomba_id', $sublomba_filter);
        })
        ->paginate(10);

    if (request()->routeIs('organizer.results.*')) {
        return view('organizer.results.index', compact('hasil', 'search', 'sublombas', 'sublomba_filter'));
    } elseif (request()->routeIs('admin.results.*')) {
        return view('admin.results.index', compact('hasil', 'search', 'sublombas', 'sublomba_filter'));
    } elseif (request()->routeIs('participant.results.*')) {
        return view('participant.results.index', compact('hasil', 'search', 'sublombas', 'sublomba_filter'));
    }

    return view('hasil.index', compact('hasil', 'search', 'sublombas', 'sublomba_filter'));
}


    public function create()
    {
        $partisipans = Partisipan::all();
        $sublombas = SubLomba::all();
        
        if (request()->routeIs('organizer.results.*')) {
            return view('organizer.results.create', compact('partisipans', 'sublombas'));
        }
        
        return view('hasil.create', compact('partisipans', 'sublombas'));
    }

    public function store(Request $request)
{
    $request->validate([
        'sublomba_id' => 'required|exists:sub_lomba,sublomba_id',
        'partisipan_id' => 'required|exists:partisipans,partisipan_id',
        'rank' => 'required|integer',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('gambar')) {
    $file = $request->file('gambar');
    $filename = time() . '_' . $file->getClientOriginalName();
    // simpan hanya path setelah 'public/'
    $data['gambar'] = 'hasil/' . $filename;
    $file->storeAs('public/hasil', $filename);
}

    Hasil::create($data);

    return redirect()->route('organizer.results.index')
        ->with('success', 'Data hasil berhasil ditambahkan');
}


    public function destroy(Hasil $hasil)
    {
        $hasil->delete();
        return redirect()->route('hasil.index')->with('success', 'Data hasil berhasil dihapus');
    }

    public function show($competition)
    {
        $event = Event::findOrFail($competition);
        $hasil = Hasil::with(['partisipan', 'sublomba'])
            ->whereHas('sublomba', function($query) use ($event) {
                $query->where('event_id', $event->id);
            })
            ->get();
        return view('participant.results.index', compact('hasil', 'event'));
    }

    public function edit($id)
    {
        $hasil = Hasil::with(['partisipan', 'sublomba'])->findOrFail($id);
        $partisipans = Partisipan::all();
        $sublombas = SubLomba::all();
        
        if (request()->routeIs('admin.results.*')) {
            return view('admin.results.edit', compact('hasil', 'partisipans', 'sublombas'));
        } elseif (request()->routeIs('organizer.results.*')) {
            return view('organizer.results.edit', compact('hasil', 'partisipans', 'sublombas'));
        }
        
        return view('hasil.edit', compact('hasil', 'partisipans', 'sublombas'));
    }

    public function update(Request $request, $id)
    {
        $hasil = Hasil::findOrFail($id);
        
        $request->validate([
            'rank' => 'required|integer',
            'deskripsi' => 'nullable|string'
        ]);

        $hasil->update($request->all());
        
        if (request()->routeIs('admin.results.*')) {
            return redirect()->route('admin.results.index')->with('success', 'Data hasil berhasil diperbarui');
        } elseif (request()->routeIs('organizer.results.*')) {
            return redirect()->route('organizer.results.index')->with('success', 'Data hasil berhasil diperbarui');
        }
        if ($request->hasFile('gambar')) {
    $file = $request->file('gambar');
    $filename = time() . '_' . $file->getClientOriginalName();
    $data['gambar'] = $file->storeAs('public/hasil', $filename);
}


        return redirect()->route('hasil.index')->with('success', 'Data hasil berhasil diperbarui');
    }

    public function previewCertificate($certificate)
    {
        $sertifikat = \App\Models\Sertifikat::with(['partisipan', 'sublomba'])
    ->whereHas('partisipan', function($q) {
        $q->where('user_id', auth()->id());
    })
    ->findOrFail($certificate);
    }
    
}

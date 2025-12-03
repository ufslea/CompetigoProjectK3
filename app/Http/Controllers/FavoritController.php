<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorit;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // hanya user login yang bisa favorit
    }

    // POST /favorit → tambah ke favorit (bisa dipanggil via AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'events_id' => 'required|exists:events,events_id',
        ]);

        $userId = Auth::user()->user_id;

        $exists = Favorit::where('user_id', $userId)
            ->where('events_id', $request->events_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'already',
                'message' => 'Event sudah ada di favorit',
            ], 200);
        }

        Favorit::create([
            'user_id'   => $userId,
            'events_id' => $request->events_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil ditambahkan ke favorit',
        ], 201);
    }

    // DELETE /favorit/{events_id} → hapus dari favorit
    public function destroy($events_id)
    {
        $userId = Auth::user()->user_id;

        Favorit::where('user_id', $userId)
            ->where('events_id', $events_id)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil dihapus dari favorit',
        ]);
    }

    // Optional: GET /favorit → daftar event favorit user (bisa untuk halaman "Favorit Saya")
    public function index()
    {
        $favorits = Favorit::with('event')
            ->where('user_id', Auth::user()->user_id)
            ->latest()
            ->paginate(12);

        return view('profile.favorites', compact('favorits'));
    }
}
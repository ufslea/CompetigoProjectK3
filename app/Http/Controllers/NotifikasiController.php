<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::with('user')->get();
        return view('notifikasi.index', compact('notifikasi'));
    }

    public function create()
    {
        $users = User::all();
        return view('notifikasi.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'judul' => 'required|string',
            'pesan' => 'required|string'
        ]);

        Notifikasi::create($request->all());
        return redirect()->route('notifikasi.index')->with('success', 'Notifikasi berhasil dikirim');
    }

    public function destroy(Notifikasi $notifikasi)
    {
        $notifikasi->delete();
        return redirect()->route('notifikasi.index')->with('success', 'Notifikasi berhasil dihapus');
    }
}

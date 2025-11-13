<?php

namespace App\Http\Controllers;

use App\Models\Partisipan;
use App\Models\User;
use App\Models\SubLomba;
use Illuminate\Http\Request;

class PartisipanController extends Controller
{
    public function index()
    {
        $partisipans = Partisipan::with(['user', 'sublomba'])->get();
        return view('partisipan.index', compact('partisipans'));
    }

    public function create()
    {
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
            'status' => 'required|string'
        ]);

        Partisipan::create($request->all());
        return redirect()->route('partisipan.index')->with('success', 'Partisipan berhasil ditambahkan');
    }

    public function edit(Partisipan $partisipan)
    {
        $users = User::all();
        $sublombas = SubLomba::all();
        return view('partisipan.edit', compact('partisipan', 'users', 'sublombas'));
    }

    public function update(Request $request, Partisipan $partisipan)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $partisipan->update($request->all());
        return redirect()->route('partisipan.index')->with('success', 'Partisipan berhasil diperbarui');
    }

    public function destroy(Partisipan $partisipan)
    {
        $partisipan->delete();
        return redirect()->route('partisipan.index')->with('success', 'Partisipan berhasil dihapus');
    }
}

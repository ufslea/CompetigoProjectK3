<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan semua user
    public function index()
    {
        $users = User::all();
        
        if (request()->routeIs('admin.users.*')) {
            return view('admin.users.index', compact('users'));
        }
        
        return view('users.index', compact('users'));
    }

    // Menampilkan form tambah user
    public function create()
    {
        return view('users.create');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'nullable|in:participant,organizer,admin',
            'no_hp' => 'nullable|string',
            'institusi' => 'nullable|string',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'participant',
            'no_hp' => $request->no_hp,
            'institusi' => $request->institusi,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    // Menampilkan detail user
    public function show($user)
    {
        $user = User::findOrFail($user);
        
        if (request()->routeIs('admin.users.*')) {
            return view('admin.users.show', compact('user'));
        }
        
        return view('users.show', compact('user'));
    }

    // Menampilkan form edit
    public function edit($user)
    {
        $user = User::findOrFail($user);
        
        if (request()->routeIs('admin.users.*')) {
            return view('admin.users.edit', compact('user'));
        }
        
        return view('users.edit', compact('user'));
    }

    // Update data user
    public function update(Request $request, $user)
    {
        $user = User::findOrFail($user);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'role' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'institusi' => 'nullable|string',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role ?? $user->role,
            'no_hp' => $request->no_hp,
            'institusi' => $request->institusi,
        ]);

        if (request()->routeIs('admin.users.*')) {
            return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
        }
        
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
    
}

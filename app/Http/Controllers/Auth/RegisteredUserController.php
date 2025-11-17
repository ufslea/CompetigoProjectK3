<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'nullable|in:participant,organizer,admin',
            'no_hp' => 'nullable|string',
            'institusi' => 'nullable|string',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'participant',
            'no_hp' => $validated['no_hp'] ?? null,
            'institusi' => $validated['institusi'] ?? null,
        ]);

        Auth::login($user);

        // Redirect berdasarkan role, tapi pastikan route tersedia
        if ($user->role === 'organizer' && Route::has('organizer.dashboard')) {
            return redirect()->route('organizer.dashboard');
        }

        if ($user->role === 'participant' && Route::has('participant.dashboard')) {
            return redirect()->route('participant.dashboard');
        }

        // fallback aman
        return redirect()->intended('/dashboard');
    }
}

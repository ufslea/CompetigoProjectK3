<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerProfileController extends Controller
{
    public function index()
    {
        return view('organizer.user.index', [
            'user' => Auth::user(),
        ]);
    }

    public function edit()
    {
        return view('organizer.user.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id() . ',user_id',
            'no_hp' => 'nullable|string',
            'institusi' => 'nullable|string',
        ]);

        Auth::user()->update($request->only(['nama', 'email', 'no_hp', 'institusi']));

        return redirect()->route('organizer.profile.index')->with('success', 'Profile updated successfully.');
    }
}


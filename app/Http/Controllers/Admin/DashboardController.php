<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Check route context to return appropriate view
        if (request()->routeIs('participant.dashboard')) {
            return view('participant.dashboard');
        }
        
        return view('admin.dashboard');
    }

    public function profile()
    {
        return view('profile.index', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id() . ',user_id',
            'no_hp' => 'nullable|string',
            'institusi' => 'nullable|string',
        ]);

        Auth::user()->update($request->only(['nama', 'email', 'no_hp', 'institusi']));

        return redirect()->route('participant.profile.index')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('participant.profile.index')->with('success', 'Password updated successfully.');
    }
}

